<?php

namespace App\Actions;

use App\Support\JobsheetCatalog;
use Illuminate\Support\Facades\File;

class SearchJobsheetContent
{
    private const STOP_WORDS = [
        'apa', 'apakah', 'bagaimana', 'mengapa', 'jelaskan', 'sebutkan', 'dengan',
        'untuk', 'pada', 'yang', 'dari', 'dalam', 'adalah', 'cara', 'suatu',
        'sebuah', 'materi', 'jobsheet', 'praktikum', 'tersebut', 'tentang',
        'fungsi', 'berapa', 'nilai', 'dan', 'atau', 'jika', 'saya', 'bisa',
        'pertama', 'kedua', 'ketiga', 'langkah', 'sebelum', 'menggunakan',
        'peralatan', 'praktik', 'hasil', 'pengamatan',
    ];

    /**
     * Extractive search over approved local jobsheet manifests; no LLM/API involved.
     *
     * @return array{answer: string, sources: array<int, array{title: string, url: string}>}|null
     */
    public function answer(string $question, JobsheetCatalog $catalog): ?array
    {
        $terms = $this->terms($question);
        $lowerQuestion = mb_strtolower($question);
        $topicTerms = array_values(array_filter($terms, fn (string $term): bool => ! in_array($term, [
            'tujuan', 'teori', 'ringkasan', 'diskusi', 'alat', 'bahan', 'jelaskan', 'kerja',
        ], true)));

        if (count($terms) < 2) {
            return null;
        }

        $candidates = [];

        foreach ($catalog->editions() as $edition) {
            foreach ($edition['modules'] as $module) {
                $moduleFile = resource_path('jobsheets/modules/'.$module['slug'].'.json');

                if (! File::isFile($moduleFile)) {
                    continue;
                }

                try {
                    $document = json_decode(File::get($moduleFile), true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException) {
                    continue;
                }

                if (($document['edition'] ?? null) !== $edition['id']
                    || ($document['slug'] ?? null) !== $module['slug']
                    || ! is_array($document['pages'] ?? null)) {
                    continue;
                }

                $titleMatches = $this->matches($module['title'], $terms);

                // Prefer matching a named module; avoid matching broad words from other jobsheets.
                if ($titleMatches === 0 || ($topicTerms !== [] && $this->matches($module['title'], $topicTerms) === 0)) {
                    continue;
                }

                foreach ($document['pages'] as $page) {
                    if (! is_array($page) || ! is_int($page['pdf_page'] ?? null)
                        || ! is_string($page['text'] ?? null)) {
                        continue;
                    }

                    foreach ($this->passages($page['text']) as $passage) {
                        $matches = $this->matches($passage, $terms);

                        // Require evidence beyond a single shared technical word.
                        if ($matches < 2 || str_ends_with(trim($passage), '?')) {
                            continue;
                        }

                        $relevantSection = match (true) {
                            str_contains($lowerQuestion, 'tujuan') => preg_match('/tujuan/i', $passage) === 1,
                            str_contains($lowerQuestion, 'alat') || str_contains($lowerQuestion, 'bahan') => preg_match('/alat|bahan/i', $passage) === 1,
                            str_contains($lowerQuestion, 'keselamatan') => preg_match('/keselamatan|catu daya|periksa/i', $passage) === 1,
                            default => false,
                        };

                        $candidates[] = [
                            'edition' => $edition,
                            'module' => $module,
                            'page' => $page['pdf_page'],
                            'passage' => $passage,
                            'score' => $matches * 3 + $titleMatches + ($relevantSection ? 5 : 0),
                            'matches' => $matches,
                        ];
                    }
                }
            }
        }

        usort($candidates, fn (array $a, array $b): int => $b['score'] <=> $a['score']);

        if ($candidates === []) {
            return null;
        }

        $best = $candidates[0];
        $excerpt = $this->excerpt($best['passage'], $terms);

        if ($excerpt === '') {
            return null;
        }

        $title = $best['module']['title'];
        $page = $best['page'];
        $url = route('jobsheet.module', [
            'edition' => $best['edition']['id'],
            'module' => $best['module']['slug'],
        ]).'#halaman-'.$page;

        return [
            'answer' => "Tutor berbasis sumber lokal — {$title} (Purwanto, 2019, halaman PDF {$page}):\n\n{$excerpt}\n\nUntuk belajar: perhatikan konsep dan langkah pada kutipan tersebut, lalu cocokkan dengan jobsheet asli. Saya tidak membuat jawaban di luar informasi yang tersedia. Gambar rangkaian, rumus, dan tabel tetap perlu diperiksa pada PDF.",
            'sources' => [
                ['title' => "Jobsheet {$title} · halaman PDF {$page}", 'url' => $url],
            ],
        ];
    }

    /** @return array<int, string> */
    private function terms(string $question): array
    {
        $words = preg_split('/[^\\p{L}\\p{N}]+/u', mb_strtolower($question)) ?: [];

        return array_values(array_unique(array_filter(
            $words,
            fn (string $word): bool => mb_strlen($word) >= 3
                && ! in_array($word, self::STOP_WORDS, true),
        )));
    }

    /** @param array<int, string> $terms */
    private function matches(string $content, array $terms): int
    {
        $content = mb_strtolower($content);

        return count(array_filter(
            $terms,
            fn (string $term): bool => preg_match(
                '/(?<![\\p{L}\\p{N}])'.preg_quote($term, '/').'(?![\\p{L}\\p{N}])/u',
                $content,
            ) === 1,
        ));
    }

    /** @return array<int, string> */
    private function passages(string $text): array
    {
        $chunks = preg_split('/\\n\\s*\\n/u', $text) ?: [];
        $results = [];

        foreach ($chunks as $chunk) {
            $chunk = trim((string) preg_replace('/\\s+/u', ' ', $chunk));

            if (mb_strlen($chunk) < 40
                || (mb_strlen($chunk) < 320 && str_contains($chunk, 'PROGRAM STUDI PENDIDIKAN TEKNIK ELEKTRONIKA'))
                || (mb_strlen($chunk) < 320 && str_contains($chunk, 'PANDUAN PRAKTIKUM INSTRUMENTASI DAN ELEKTRONIKA'))
                || preg_match('/^Tabel \\d+\\./u', $chunk) === 1) {
                continue;
            }

            // Split very long blocks at sentence boundaries where possible.
            if (mb_strlen($chunk) > 950) {
                foreach (preg_split('/(?<=[.!?])\\s+/u', $chunk) ?: [] as $sentence) {
                    if (mb_strlen($sentence) >= 40) {
                        $results[] = $sentence;
                    }
                }
            } else {
                $results[] = $chunk;
            }
        }

        return $results;
    }

    /** @param array<int, string> $terms */
    private function excerpt(string $passage, array $terms): string
    {
        $text = trim((string) preg_replace('/\\s+/u', ' ', $passage));

        if (mb_strlen($text) <= 700) {
            return $text;
        }

        $offset = 0;

        foreach ($terms as $term) {
            $found = mb_stripos($text, $term);

            if ($found !== false) {
                $offset = max(0, $found - 100);
                break;
            }
        }

        return ($offset > 0 ? '…' : '').mb_substr($text, $offset, 700).'…';
    }
}
