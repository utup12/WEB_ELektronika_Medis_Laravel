<?php

test('pilot exposes prerequisites, K3, assessment rubric and editable observations', function () {
    $this->get(route('pilot.heart-rate'))
        ->assertOk()
        ->assertSee('Prasyarat dan persiapan')
        ->assertSee('Keselamatan dan privasi')
        ->assertSee('Indikator keberhasilan tahap pilot')
        ->assertSee('Rubrik penilaian formatif sementara')
        ->assertSee('id="pilot-observation-table"', false)
        ->assertSee('id="pilot-bpm-1"', false)
        ->assertSee('id="pilot-bpm-2"', false)
        ->assertSee('id="pilot-bpm-3"', false)
        ->assertSee('pilot-heart-rate-reflection-v1');
});

test('assistant evaluation corpus contains 28 unique and categorised questions', function () {
    $json = file_get_contents(resource_path('ai-evaluation/baseline-cases.json'));
    $corpus = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    $cases = $corpus['cases'];

    expect($cases)->toHaveCount(28);

    $ids = array_column($cases, 'id');
    expect(count(array_unique($ids)))->toBe(28);

    $counts = array_count_values(array_column($cases, 'category'));
    expect($counts['retrieval'])->toBe(17)
        ->and($counts['calculation'])->toBe(5)
        ->and($counts['outside_scope'])->toBe(4)
        ->and($counts['greeting'])->toBe(2);

    foreach ($cases as $case) {
        expect($case['question'])->toBeString()->not->toBeEmpty()
            ->and($case['expected_contains'])->toBeString()->not->toBeEmpty()
            ->and($case['review_status'])->toBe('pending_human_review');
    }
});

test('AI baseline evaluator has no external AI dependency and produces reproducible raw artifacts', function () {
    $evaluator = file_get_contents(base_path('scripts/evaluate_ai_baseline.php'));
    expect($evaluator)->toContain('AnswerPracticeQuestion::class')
        ->toContain("results.csv")
        ->toContain("results.json")
        ->toContain('requires_human_review');
});
