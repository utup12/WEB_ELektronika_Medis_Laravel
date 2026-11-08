<?php

dataset('assistant grounded baseline', [
    'report format' => [
        'Apa format laporan yang disarankan?',
        'Unggah Laporan',
        'PDF',
    ],
    'monitor BLE service' => [
        'Layanan BLE apa yang diperlukan untuk membaca BPM nyata?',
        'Monitor Trainer',
        'Heart Rate Service',
    ],
    'trainer diagnostic boundary' => [
        'Apakah data trainer digunakan untuk diagnosis medis?',
        'Monitor Trainer',
        'bukan hasil diagnosis',
    ],
]);

test('assistant baseline stays grounded in expected learning sources', function (
    string $message,
    string $expectedSource,
    string $expectedAnswerFragment,
) {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => $message,
    ]);

    $response->assertOk();

    expect(collect($response->json('sources'))->pluck('title'))
        ->toContain($expectedSource);

    expect($response->json('answer'))
        ->toContain($expectedAnswerFragment);
})->with('assistant grounded baseline');

test('assistant baseline keeps unsupported general knowledge outside its scope', function () {
    $response = $this->postJson(route('asisten-ai.chat'), [
        'message' => 'Siapa presiden Indonesia saat ini?',
    ]);

    $response->assertOk();
    $response->assertJsonPath('sources', []);

    expect($response->json('answer'))
        ->toStartWith('Saya belum menemukan jawaban');
});
