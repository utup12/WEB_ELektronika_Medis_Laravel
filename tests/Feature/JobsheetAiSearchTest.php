<?php

test('assistant can retrieve a grounded source passage from the AD620 jobsheet', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Jelaskan penguatan AD620 dan resistor RG',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('Tutor berbasis sumber lokal', 'halaman PDF');
    expect($response->json('sources.0.title'))->toContain('AD620');
    expect($response->json('sources.0.url'))->toContain('/jobsheet/', '#halaman-');
});

test('assistant keeps its current grounding and refuses irrelevant questions', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Siapa presiden Indonesia saat ini?',
    ]);

    $response->assertOk()->assertJsonPath('sources', []);
    expect($response->json('answer'))->toStartWith('Saya belum menemukan jawaban');
});

test('verified AD620 equation is visible on its jobsheet detail page', function () {
    $this->get(route('jobsheet.module', [
        'edition' => 'panduan-instrumentasi-elektronika-medis-2019',
        'module' => 'penguat-ad620',
    ]))
        ->assertOk()
        ->assertSee('Persamaan yang sudah diverifikasi')
        ->assertSee('49,4 kΩ');
});
