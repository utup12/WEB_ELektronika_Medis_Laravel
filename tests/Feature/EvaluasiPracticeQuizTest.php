<?php

use App\Support\JobsheetCatalog;
use App\Support\JobsheetPracticeQuizzes;

test('every jobsheet module has 10 valid multiple choice practice questions', function () {
    $catalogEdition = collect(app(JobsheetCatalog::class)->editions())
        ->firstWhere('id', 'panduan-instrumentasi-elektronika-medis-2019');
    $catalogSlugs = collect($catalogEdition['modules'])->pluck('slug')->all();

    $quizzes = app(JobsheetPracticeQuizzes::class)->all();

    expect($quizzes)->toHaveCount(14);
    expect(collect($quizzes)->pluck('slug')->all())->toBe($catalogSlugs);

    foreach ($quizzes as $module) {
        expect($module['questions'])->toHaveCount(10);

        foreach ($module['questions'] as $question) {
            expect($question['question'])->toBeString()->not->toBeEmpty()
                ->and($question['answer'])->toBeIn(['a', 'b', 'c', 'd'])
                ->and($question['explanation'])->toBeString()->not->toBeEmpty()
                ->and(array_keys($question['options']))->toBe(['a', 'b', 'c', 'd']);
        }
    }
});

test('evaluasi page renders per-jobsheet practice quiz interface for guests and authenticated users', function () {
    $response = $this->get(route('evaluasi'));

    $response->assertOk()
        ->assertSee('Hanya untuk latihan · tidak masuk nilai resmi')
        ->assertSee('Latihan Soal per Jobsheet (10 Soal Pilihan Ganda)')
        ->assertSee('Jobsheet 1 · Penguat Instrumentasi')
        ->assertSee('Jobsheet 14 · Electromyogram (EMG)')
        ->assertSee('Selesai & Lihat Skor', false)
        ->assertSee('evaluasi-practice.js');
});
