<?php

use App\Support\JobsheetCatalog;

test('2019 jobsheet catalog contains fourteen topics', function () {
    $edition = collect(app(JobsheetCatalog::class)->editions())
        ->firstWhere('id', 'panduan-instrumentasi-elektronika-medis-2019');

    expect($edition)->not->toBeNull();
    expect($edition['modules'])->toHaveCount(14);
    expect(collect($edition['modules'])->pluck('slug')->unique())->toHaveCount(14);
});

test('praktikum page merges panduan first, jobsheet catalog with mulai praktikum, and smartwatch simulation at the bottom', function () {
    $response = $this->get(route('praktikum'));

    $response->assertOk()
        ->assertSeeInOrder([
            'Panduan Praktikum',
            '01 · Sebelum',
            'Katalog Jobsheet',
            'Penguat Instrumentasi',
            'Notch Filter',
            'Electromyogram (EMG)',
            'Mulai Praktikum',
            'Praktikum Simulasi: Heart Rate Smartwatch (PPG)',
        ])
        ->assertDontSee('Monitor Heart Rate')
        ->assertDontSee('Praktik dengan Trainer Kit');

    $this->get(route('jobsheet'))
        ->assertRedirect('/praktikum#jobsheet');
});

test('jobsheet topic route renders source information and practice quiz link', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertSee('Penguat AD620')
        ->assertSee('Mulai halaman PDF: 14')
        ->assertSee('Arsip Teks PDF per Halaman')
        ->assertSee('Halaman PDF 14')
        ->assertSee('49,4')
        ->assertSee('Latihan 10 Soal Jobsheet Ini');
});

test('unknown jobsheet topic returns not found', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'tidak-ada',
    ]))->assertNotFound();
});
