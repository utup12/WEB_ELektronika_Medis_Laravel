<?php

test('asisten AI page renders the chat interface', function () {
    $response = $this->get(route('asisten-ai'));

    $response->assertOk();
    $response->assertSee('Tanya Praktik Elektronika Medis');
    $response->assertSee('chat-message', false);
});

test('asisten AI returns an answer with a website source for a practice question', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Apa langkah pertama sebelum menggunakan peralatan praktikum?',
    ]);

    $response->assertOk();
    $response->assertJsonPath('sources.0.title', 'Evaluasi Praktikum');
    $response->assertJsonPath('sources.0.url', route('evaluasi'));

    expect($response->json('answer'))->toContain('Memeriksa prosedur keselamatan dan kondisi alat.');
});

test('asisten AI answers a greeting without a website source', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Selamat siang!',
    ]);

    $response->assertOk();
    $response->assertJsonPath('answer', 'Selamat siang! Saya Asisten Praktik Elektronika Medis. Ada yang bisa saya bantu terkait praktikum?');
    $response->assertJsonPath('sources', []);
});

test('asisten AI rejects an empty question with a validation error', function () {
    $response = $this->postJson(route('asisten-ai.chat'), []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors([
        'message' => 'Tulis pertanyaan terlebih dahulu.',
    ]);
});

test('asisten AI does not answer questions outside the website sources', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Siapa presiden Indonesia saat ini?',
    ]);

    $response->assertOk();
    $response->assertJsonPath('sources', []);

    expect($response->json('answer'))->toStartWith('Saya belum menemukan jawaban');
});
