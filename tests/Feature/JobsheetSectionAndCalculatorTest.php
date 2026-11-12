<?php

use App\Support\JobsheetSectionIndex;

test('section index preserves PDF page and instructional section labels', function () {
    $sections = app(JobsheetSectionIndex::class)->build([
        ['pdf_page' => 14, 'text' => "A. Tujuan:\nMahasiswa mampu menjelaskan cara kerja AD620.\n\nB. Rangkuman Teori:\nRangkaian penguat instrumentasi."],
        ['pdf_page' => 15, 'text' => 'Penguatan diatur melalui resistor RG.'],
    ]);

    expect($sections)->toHaveCount(3);
    expect($sections[0]['section'])->toBe('Tujuan');
    expect($sections[1]['section'])->toBe('Rangkuman Teori');
    expect($sections[2]['pdf_page'])->toBe(15);
    expect($sections[2]['section'])->toBe('Rangkuman Teori');
});

test('AD620 module renders a browser calculator with both directions', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertSee('Daftar bagian materi')
        ->assertSee('Kalkulator Interaktif AD620')
        ->assertSee('Cari RG dari gain')
        ->assertSee('Cari gain dari RG')
        ->assertSee('js/ad620-calculator.js');
});

test('other jobsheet modules do not show AD620 calculator', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'electrocardiogram-ecg',
    ]))
        ->assertOk()
        ->assertDontSee('data-ad620-calculator');
});
