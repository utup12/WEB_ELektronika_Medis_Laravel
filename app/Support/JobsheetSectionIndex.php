<?php

namespace App\Support;

class JobsheetSectionIndex
{
    /**
     * Split extracted PDF text into instructional sections without altering the source text.
     *
     * @param  array<int, array{pdf_page: int, text: string}>  $pages
     * @return array<int, array{pdf_page: int, section: string, text: string}>
     */
    public function build(array $pages): array
    {
        $indexed = [];
        $currentSection = 'Pengantar';

        foreach ($pages as $page) {
            $parts = preg_split(
                '/(?m)^\\s*[A-F]\\.\\s*(Tujuan|Rangkuman Teori|Kesehatan dan Keselamatan Kerja|Alat Bahan|Alat dan Bahan|Langkah percobaan|Langkah kerja|Diskusi)\\s*:\\s*/iu',
                $page['text'],
                -1,
                PREG_SPLIT_DELIM_CAPTURE,
            ) ?: [];

            foreach ($parts as $position => $part) {
                if ($position % 2 === 1) {
                    $currentSection = trim($part);

                    continue;
                }

                $text = trim($part);

                if ($text !== '') {
                    $indexed[] = [
                        'pdf_page' => $page['pdf_page'],
                        'section' => $currentSection,
                        'text' => $text,
                    ];
                }
            }
        }

        return $indexed;
    }
}
