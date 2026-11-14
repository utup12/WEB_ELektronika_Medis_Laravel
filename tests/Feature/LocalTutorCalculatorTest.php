<?php

use Illuminate\Support\Facades\Http;

test('AD620 local calculator finds RG for gain one hundred', function () {
    Http::fake();

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Hitung RG AD620 untuk gain 100 kali',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('498,99', '49.400');
    expect($response->json('sources.0.title'))->toContain('AD620');
    Http::assertNothingSent();
});

test('AD620 local calculator finds gain from one kiloohm', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Hitung gain AD620 jika RG 1 kΩ',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('50,40');
});

test('AD620 local calculator rejects gain of one to avoid division by zero', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Hitung RG AD620 untuk gain 1 kali',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('lebih besar dari 1');
});

test('AD620 local calculator asks for resistor units when omitted', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Hitung gain AD620 untuk RG 500',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('satuan');
});

test('assistant never calls external AI even if an old API key exists', function () {
    config()->set('services.jobsheet_llm.key', 'old-key');
    Http::fake();

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Jelaskan penguatan AD620 dan resistor RG',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('AD620');
    Http::assertNothingSent();
});
