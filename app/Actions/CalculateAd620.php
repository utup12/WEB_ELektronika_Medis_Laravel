<?php

namespace App\Actions;

use App\Support\JobsheetCatalog;

class CalculateAd620
{
    /**
     * @return array{answer: string, sources: array<int, array{title: string, url: string}>}|null
     */
    public function answer(string $question): ?array
    {
        $text = mb_strtolower($question);

        if (! preg_match('/\bad\s*-?\s*620\b/u', $text)) {
            return null;
        }

        $wantsCalculation = preg_match('/hitung|berapa|tentukan|kalkulasi|cari\s+nilai|rancang|membuat\s+penguatan/u', $text) === 1;

        if (! $wantsCalculation) {
            return null;
        }

        $source = [
            'title' => 'Jobsheet Penguat AD620 · halaman PDF 16',
            'url' => route('jobsheet.module', [
                'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
                'module' => 'penguat-ad620',
            ]).'#halaman-16',
        ];

        // Require explicit gain context; reject ambiguous bare numeric quantities.
        $gainFound = preg_match('/(?:penguatan|gain|\bg\b)\s*(?:sebesar|adalah|=|:|mencapai|hingga)?\s*(\d+(?:[.,]\d+)?)\s*(?:kali|x)?/u', $text, $gain);
        $resistorFound = preg_match('/(?:\br[_\s-]?g\b|resistor\s+(?:gain|penguatan))\s*(?:sebesar|adalah|=|:|bernilai)?\s*(\d+(?:[.,]\d+)?)\s*(kω|kohm|kiloohm|kilo\s*ohm|ω|ohm|k|r)?\b/ui', $text, $resistor);

        if ($gainFound === 1 && $resistorFound === 1) {
            return [
                'answer' => 'Berikan salah satu parameter saja (gain G atau resistor RG) agar perhitungan AD620 tidak ambigu. Contoh: "Hitung RG AD620 untuk gain 100 kali".',
                'sources' => [$source],
            ];
        }

        if ($gainFound === 1) {
            $value = (float) str_replace(',', '.', $gain[1]);

            if (! is_finite($value) || $value <= 1 || $value > 10000) {
                return [
                    'answer' => 'Masukkan gain G lebih besar dari 1 dan maksimal 10.000 untuk kalkulator pembelajaran ini. Persamaan RG = 49,4 kΩ / (G − 1).',
                    'sources' => [$source],
                ];
            }

            $rgOhm = 49400 / ($value - 1);

            return [
                'answer' => 'Kalkulator AD620 (model ideal, sesuai Jobsheet 2019):'."\n"
                    .'G = '.number_format($value, 2, ',', '.')." kali\n"
                    .'RG = 49.400 Ω / (G − 1)'."\n"
                    .'RG = 49.400 / '.number_format($value - 1, 2, ',', '.').' = '
                    .number_format($rgOhm, 2, ',', '.')." Ω\n\n"
                    .'Gunakan resistor standar yang mendekati nilai teoritis, lalu hitung ulang gain aktual. '
                    .'Hasil ini bukan jaminan keamanan rangkaian untuk pengukuran pada tubuh manusia.',
                'sources' => [$source],
            ];
        }

        if ($resistorFound === 1) {
            $value = (float) str_replace(',', '.', $resistor[1]);
            $unit = mb_strtolower(trim($resistor[2] ?? ''));

            if ($unit === '') {
                return [
                    'answer' => 'Cantumkan satuan resistor RG, misalnya "Hitung gain AD620 untuk RG 1 kΩ" atau "RG 500 ohm".',
                    'sources' => [$source],
                ];
            }

            if (in_array($unit, ['kω', 'kohm', 'kiloohm', 'kilo ohm', 'k'], true)) {
                $value *= 1000;
            }

            if (! is_finite($value) || $value <= 0 || $value > 10000000) {
                return [
                    'answer' => 'Resistor RG harus bernilai positif dan berada dalam rentang kalkulator (maksimal 10 MΩ).',
                    'sources' => [$source],
                ];
            }

            $gainValue = 1 + 49400 / $value;

            return [
                'answer' => 'Kalkulator AD620 (model ideal, sesuai Jobsheet 2019):'."\n"
                    .'RG = '.number_format($value, 2, ',', '.')." Ω\n"
                    .'G = 1 + (49.400 Ω / RG)'."\n"
                    .'G = '.number_format($gainValue, 2, ',', '.')." kali\n\n"
                    .'Penguatan aktual harus diperiksa pada rangkaian fisik. '
                    .'Hasil perhitungan bukan panduan keselamatan perangkat yang tersambung ke tubuh.',
                'sources' => [$source],
            ];
        }

        return [
            'answer' => 'Untuk menghitung AD620, tulis salah satu contoh: "Hitung RG AD620 untuk gain 100 kali" atau "Hitung gain AD620 jika RG 1 kΩ". Rumus Jobsheet 2019: G = 1 + (49,4 kΩ / RG).',
            'sources' => [$source],
        ];
    }
}
