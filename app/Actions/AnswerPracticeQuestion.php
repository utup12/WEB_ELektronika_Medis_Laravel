<?php

namespace App\Actions;

use Illuminate\Support\Facades\File;

class AnswerPracticeQuestion
{
    /**
     * @var array<int, array{title: string, route: string, view: string}>
     */
    private const SOURCES = [
        ['title' => 'Beranda', 'route' => 'home', 'view' => 'home'],
        ['title' => 'Materi Praktikum', 'route' => 'materi', 'view' => 'materi'],
        ['title' => 'Jobsheet Praktikum', 'route' => 'jobsheet', 'view' => 'jobsheet'],
        ['title' => 'Panduan Praktikum', 'route' => 'panduan-praktikum', 'view' => 'panduan-praktikum'],
        ['title' => 'Praktikum', 'route' => 'praktikum', 'view' => 'praktikum'],
        ['title' => 'Evaluasi Praktikum', 'route' => 'evaluasi', 'view' => 'evaluasi'],
        ['title' => 'Unggah Laporan', 'route' => 'laporan', 'view' => 'laporan'],
    ];

    /**
     * @var array<int, string>
     */
    private const STOP_WORDS = [
        'ada', 'agar', 'akan', 'apa', 'atau', 'bagaimana', 'bagi', 'bisa', 'dalam',
        'dan', 'dari', 'dengan', 'ini', 'itu', 'jika', 'juga', 'kah', 'ke', 'karena',
        'kapan', 'kami', 'kamu', 'mana', 'mengenai', 'pada', 'saat', 'saja', 'saya', 'sebuah',
        'serta', 'siapa', 'tentang', 'untuk', 'yang',
    ];

    /**
     * Answer a question using only the learning content that appears on this website.
     *
     * @return array{answer: string, sources: array<int, array{title: string, url: string}>}
     */
    public function handle(string $question): array
    {
        $terms = $this->searchTerms($question);

        $sources = collect(self::SOURCES)
            ->map(function (array $source) use ($terms): array {
                $content = $this->contentFor($source['view']);

                return [
                    ...$source,
                    'content' => $content,
                    'score' => $this->score($content, $terms),
                ];
            })
            ->filter(fn (array $source): bool => $source['score'] > 0)
            ->sortByDesc('score')
            ->take(3)
            ->values();

        if ($sources->isEmpty()) {
            return [
                'answer' => 'Saya belum menemukan jawaban untuk pertanyaan itu dalam materi, jobsheet, panduan, praktikum, evaluasi, atau halaman laporan di website ini. Coba gunakan istilah yang ada di halaman pembelajaran atau buka sumber terkait.',
                'sources' => [],
            ];
        }

        $bestSource = $sources->first();
        $highlights = $this->highlights($bestSource['content'], $terms);

        return [
            'answer' => $this->answerFrom($bestSource['title'], $highlights),
            'sources' => $sources
                ->map(fn (array $source): array => [
                    'title' => $source['title'],
                    'url' => route($source['route']),
                ])
                ->all(),
        ];
    }

    /**
     * Extract the main content from an existing website view, keeping the assistant's
     * knowledge synchronized with the published learning pages.
     */
    private function contentFor(string $view): string
    {
        $template = File::get(resource_path("views/{$view}.blade.php"));

        preg_match('/<main\\b[^>]*>(.*?)<\\/main>/is', $template, $matches);

        $mainContent = $matches[1] ?? '';
        $withoutBladeExpressions = preg_replace('/{{.*?}}/s', ' ', $mainContent) ?? '';
        $plainText = preg_replace('/<[^>]+>/', ' ', $withoutBladeExpressions) ?? '';

        return trim((string) preg_replace('/\\s+/u', ' ', html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    /**
     * @return array<int, string>
     */
    private function searchTerms(string $question): array
    {
        $words = preg_split('/[^\\p{L}\\p{N}]+/u', mb_strtolower($question)) ?: [];

        return array_values(array_unique(array_filter(
            $words,
            fn (string $word): bool => mb_strlen($word) >= 3
                && ! in_array($word, self::STOP_WORDS, true),
        )));
    }

    /**
     * @param array<int, string> $terms
     */
    private function score(string $content, array $terms): int
    {
        $searchableContent = mb_strtolower($content);
        $score = collect($terms)
            ->filter(fn (string $term): bool => $this->containsTerm($searchableContent, $term))
            ->count();

        foreach (array_keys($terms) as $index) {
            $nextTerm = $terms[$index + 1] ?? null;

            if ($nextTerm !== null && $this->containsPhrase($searchableContent, $terms[$index].' '.$nextTerm)) {
                $score += 2;
            }
        }

        return $score;
    }

    private function containsTerm(string $content, string $term): bool
    {
        return preg_match(
            '/(?<![\\p{L}\\p{N}])'.preg_quote($term, '/').'(?![\\p{L}\\p{N}])/u',
            $content,
        ) === 1;
    }

    private function containsPhrase(string $content, string $phrase): bool
    {
        return preg_match(
            '/(?<![\\p{L}\\p{N}])'.preg_quote($phrase, '/').'(?![\\p{L}\\p{N}])/u',
            $content,
        ) === 1;
    }

    /**
     * @param array<int, string> $terms
     * @return array<int, string>
     */
    private function highlights(string $content, array $terms): array
    {
        $sentences = collect(preg_split('/(?<=[.!?])\\s+/u', $content) ?: [])
            ->map(fn (string $sentence): string => trim($sentence))
            ->filter()
            ->values();

        $scoredSentences = $sentences
            ->map(fn (string $sentence): array => [
                'sentence' => $sentence,
                'score' => $this->score($sentence, $terms),
            ]);

        $bestSentenceIndex = $scoredSentences
            ->sortByDesc('score')
            ->keys()
            ->first();

        if ($bestSentenceIndex !== null) {
            $bestSentence = $scoredSentences->get($bestSentenceIndex);
            $followingSentence = $scoredSentences->get($bestSentenceIndex + 1);

            if (str_ends_with($bestSentence['sentence'], '?') && $followingSentence !== null) {
                return [$followingSentence['sentence']];
            }
        }

        return $scoredSentences
            ->filter(fn (array $sentence): bool => $sentence['score'] > 0)
            ->sortByDesc('score')
            ->pluck('sentence')
            ->take(1)
            ->values()
            ->all();
    }

    /**
     * @param array<int, string> $highlights
     */
    private function answerFrom(string $sourceTitle, array $highlights): string
    {
        if ($highlights === []) {
            return "Halaman {$sourceTitle} membahas topik tersebut, tetapi belum memuat penjelasan yang cukup rinci untuk menjawab pertanyaan ini.";
        }

        return "Berdasarkan {$sourceTitle}: ".implode(' ', $highlights);
    }
}
