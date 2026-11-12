<?php

use App\Support\JobsheetCatalog;

test('2019 jobsheet catalog contains fourteen topics', function () {
    $edition = collect(app(JobsheetCatalog::class)->editions())
        ->firstWhere('id', 'panduan-instrumentasi-elektronika-medis-2019');

    expect($edition)->not->toBeNull();
    expect($edition['modules'])->toHaveCount(14);
    expect(collect($edition['modules'])->pluck('slug')->unique())->toHaveCount(14);
});

test('jobsheet catalog route renders available editions and topics', function () {
    $this->get(route('jobsheet'))
        ->assertOk()
        ->assertSee('Katalog Jobsheet')
        ->assertSee('Penguat Instrumentasi')
        ->assertSee('Notch Filter')
        ->assertSee('Electromyogram (EMG)');
});

test('jobsheet topic route renders source information', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertSee('Penguat AD620')
        ->assertSee('Mulai halaman PDF: 14')
        ->assertSee('Arsip Teks PDF per Halaman')
        ->assertSee('Halaman PDF 14')
        ->assertSee('49,4');
});

test('unknown jobsheet topic returns not found', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'tidak-ada',
    ]))->assertNotFound();
});
