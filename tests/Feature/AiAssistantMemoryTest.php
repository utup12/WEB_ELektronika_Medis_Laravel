<?php

use App\Models\AiConversationHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('ai conversation history is saved per user and isolated between users', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $responseA = $this->actingAs($userA)->postJson('/asisten-ai/chat', [
        'message' => 'Hitung RG AD620 untuk gain 250 kali',
    ]);

    $responseA->assertOk()
        ->assertJsonPath('memory.used', 1)
        ->assertJsonPath('memory.limit', AiConversationHistory::LIMIT_PER_PERSON)
        ->assertJsonPath('memory.is_full', false);

    expect(AiConversationHistory::where('owner_key', 'user:'.$userA->id)->count())->toBe(1)
        ->and(AiConversationHistory::where('owner_key', 'user:'.$userB->id)->count())->toBe(0);

    $this->actingAs($userA)->get('/asisten-ai')
        ->assertOk()
        ->assertSee('Hitung RG AD620 untuk gain 250 kali');

    $this->actingAs($userB)->get('/asisten-ai')
        ->assertOk()
        ->assertDontSee('Hitung RG AD620 untuk gain 250 kali');
});

test('guest session saves conversation history and enforces limit with warning', function () {
    $limit = AiConversationHistory::LIMIT_PER_PERSON;

    for ($i = 1; $i < $limit; $i++) {
        $this->postJson('/asisten-ai/chat', [
            'message' => 'halo',
        ])->assertOk()
            ->assertJsonPath('memory.used', $i)
            ->assertJsonPath('memory.is_full', false);
    }

    $tenth = $this->postJson('/asisten-ai/chat', [
        'message' => 'halo',
    ]);

    $tenth->assertOk()
        ->assertJsonPath('memory.used', $limit)
        ->assertJsonPath('memory.remaining', 0)
        ->assertJsonPath('memory.is_full', true)
        ->assertJsonStructure(['memory_warning']);

    $eleventh = $this->postJson('/asisten-ai/chat', [
        'message' => 'Hitung RG AD620 untuk gain 50 kali',
    ]);

    $eleventh->assertOk()
        ->assertJsonPath('memory_full', true)
        ->assertJsonPath('memory.is_full', true)
        ->assertJsonStructure(['memory_warning']);

    expect(AiConversationHistory::count())->toBe($limit);
});

test('reset memory clears only the current person history and allows new messages', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $this->actingAs($userB)->postJson('/asisten-ai/chat', [
        'message' => 'halo',
    ])->assertOk();

    for ($i = 1; $i <= AiConversationHistory::LIMIT_PER_PERSON; $i++) {
        $this->actingAs($userA)->postJson('/asisten-ai/chat', [
            'message' => 'halo',
        ])->assertOk();
    }

    expect(AiConversationHistory::where('owner_key', 'user:'.$userA->id)->count())
        ->toBe(AiConversationHistory::LIMIT_PER_PERSON);

    $reset = $this->actingAs($userA)->postJson('/asisten-ai/reset');

    $reset->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonPath('memory.used', 0)
        ->assertJsonPath('memory.is_full', false);

    expect(AiConversationHistory::where('owner_key', 'user:'.$userA->id)->count())->toBe(0)
        ->and(AiConversationHistory::where('owner_key', 'user:'.$userB->id)->count())->toBe(1);

    $this->actingAs($userA)->postJson('/asisten-ai/chat', [
        'message' => 'Hitung RG AD620 untuk gain 100 kali',
    ])->assertOk()
        ->assertJsonPath('memory.used', 1)
        ->assertJsonPath('memory.is_full', false);
});

test('ai supports acronym synonyms and short follow up questions from memory', function () {
    $user = User::factory()->create();

    $first = $this->actingAs($user)->postJson('/asisten-ai/chat', [
        'message' => 'Jelaskan prinsip kerja sensor optik PPG dan saturasi oksigen SpO2',
    ]);

    $first->assertOk();
    expect($first->json('answer'))->not->toStartWith('Saya belum menemukan jawaban');

    $followUp = $this->actingAs($user)->postJson('/asisten-ai/chat', [
        'message' => 'jelaskan lebih lanjut',
    ]);

    $followUp->assertOk();
    expect($followUp->json('answer'))->not->toStartWith('Saya belum menemukan jawaban');
});
