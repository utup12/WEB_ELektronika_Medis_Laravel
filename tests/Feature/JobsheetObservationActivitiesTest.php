<?php

use App\Support\JobsheetCatalog;

test('source verified AD620 table has ten resistor rows with empty measurements', function () {
    $activity = json_decode(file_get_contents(resource_path('jobsheets/activities/penguat-ad620.json')), true, 512, JSON_THROW_ON_ERROR);
    $table = $activity['tables'][0];

    expect($table['pdf_page'])->toBe(18);
    expect($table['number'])->toBe(3);
    expect($table['rows'])->toHaveCount(10);
    expect($table['rows'][0]['rg'])->toBe(47000);
    expect($table['rows'][9]['rg'])->toBe(2700);
    expect($table['rows'][0])->not->toHaveKey('vout_measured');
    expect($table['rows'][0])->not->toHaveKey('vin2');
});

test('LPF source tables carry frequency rows and preserved theoretical values', function () {
    $activity = json_decode(file_get_contents(resource_path('jobsheets/activities/low-pass-orde-pertama.json')), true, 512, JSON_THROW_ON_ERROR);

    expect($activity['tables'])->toHaveCount(2);
    expect($activity['tables'][0]['pdf_page'])->toBe(27);
    expect($activity['tables'][1]['pdf_page'])->toBe(28);
    expect($activity['tables'][0]['rows'])->toHaveCount(13);
    expect($activity['tables'][0]['rows'][9]['frequency'])->toBe(1000);
    expect($activity['tables'][0]['rows'][9]['theoretical_db'])->toBe(-3.01);
});

test('AD620 jobsheet renders an editable observation table and original discussion', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertSee('Tabel Pengamatan Digital')
        ->assertSee('Tabel 3.')
        ->assertSee('Unduh CSV hasil pengamatan')
        ->assertSee('Latihan Diskusi dari Jobsheet')
        ->assertSee('js/jobsheet-observations.js');
});

test('LPF jobsheet renders both source tables', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'low-pass-orde-pertama',
    ]))
        ->assertOk()
        ->assertSee('Tabel 6.')
        ->assertSee('Tabel 7.')
        ->assertSee('kolom bantu');
});

test('modules without verified activity tables stay available', function () {
    $found = app(JobsheetCatalog::class)->module(
        'panduan-instrumentasi-elektronika-medis-2019',
        'electrocardiogram-ecg',
    );

    expect($found)->not->toBeNull();
    expect($found['activities']['tables'])->toBe([]);
    expect($found['activities']['discussion'])->toBe([]);
});

test('LPF tables have source-linked frequency charts without invented readings', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'low-pass-orde-pertama',
    ]))
        ->assertOk()
        ->assertSee('Grafik respons frekuensi')
        ->assertSee('data-frequency-table="lpf-t6"', false)
        ->assertSee('data-frequency-table="lpf-t7"', false)
        ->assertSee('Unduh grafik SVG')
        ->assertSee('js/jobsheet-frequency-chart.js');
});

test('AD620 page has no LPF frequency chart', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertDontSee('data-frequency-chart', false);
});
