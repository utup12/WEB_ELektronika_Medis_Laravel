<?php

use Illuminate\Support\Facades\Http;

test('tutor falls back to local jobsheet excerpt when API key is missing', function () {
    config()->set('services.jobsheet_llm.key', null);
    Http::fake();

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Jelaskan penguatan AD620 dan resistor RG',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('Kutipan relevan dari Jobsheet');
    Http::assertNothingSent();
});

test('tutor reformulates a retrieved passage using server side provider', function () {
    config()->set('services.jobsheet_llm.key', 'test-secret-not-real');
    config()->set('services.jobsheet_llm.model', 'test-model');
    config()->set('services.jobsheet_llm.url', 'https://api.openai.com/v1/chat/completions');

    Http::fake([
        'api.openai.com/*' => Http::response([
            'choices' => [['message' => ['content' => 'AD620 menggunakan resistor RG untuk mengatur gain.']]],
        ]),
    ]);

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Jelaskan penguatan AD620 dan resistor RG',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('AD620 menggunakan resistor RG');
    expect($response->json('sources.0.title'))->toContain('AD620');
    Http::assertSentCount(1);
});

test('tutor retains local excerpt when provider fails', function () {
    config()->set('services.jobsheet_llm.key', 'test-secret-not-real');
    config()->set('services.jobsheet_llm.url', 'https://api.openai.com/v1/chat/completions');
    Http::fake(['api.openai.com/*' => Http::response(['error' => 'unavailable'], 503)]);

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Jelaskan penguatan AD620 dan resistor RG',
    ]);

    $response->assertOk();
    expect($response->json('answer'))->toContain('Kutipan relevan dari Jobsheet');
});

test('tutor does not contact external API for unsupported general knowledge', function () {
    config()->set('services.jobsheet_llm.key', 'test-secret-not-real');
    Http::fake();

    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Siapa presiden Indonesia saat ini?',
    ]);

    $response->assertOk()->assertJsonPath('sources', []);
    Http::assertNothingSent();
});
