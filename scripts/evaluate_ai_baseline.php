<?php

declare(strict_types=1);

use App\Actions\AnswerPracticeQuestion;
use Illuminate\Contracts\Console\Kernel;

// CLI evaluation of the current grounded-retrieval baseline; no external LLM call.
require dirname(__DIR__).'/vendor/autoload.php';

$app = require dirname(__DIR__).'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$file = dirname(__DIR__).'/resources/ai-evaluation/baseline-cases.json';
$dataset = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
$cases = $dataset['cases'] ?? [];
if (count($cases) < 20 || count($cases) > 30) {
    fwrite(STDERR, "Expected 20–30 evaluation cases.\n");
    exit(1);
}

$answerer = app(AnswerPracticeQuestion::class);
$results = [];
foreach ($cases as $case) {
    $answer = $answerer->handle($case['question']);
    $titles = array_column($answer['sources'], 'title');
    $expectedSource = $case['expected_source'];
    $sourceHit = $expectedSource === null
        ? count($titles) === 0
        : in_array($expectedSource, $titles, true);
    $textHit = mb_stripos($answer['answer'], $case['expected_contains']) !== false;
    $results[] = [
        'id' => $case['id'],
        'category' => $case['category'],
        'question' => $case['question'],
        'expected_source' => $expectedSource,
        'actual_sources' => $titles,
        'expected_contains' => $case['expected_contains'],
        'source_hit' => $sourceHit,
        'text_hit' => $textHit,
        'answer' => $answer['answer'],
        'human_relevance_0_2' => null,
        'human_groundedness_0_2' => null,
        'human_unsupported_claim_0_2' => null,
        'human_completeness_0_2' => null,
        'human_notes' => '',
    ];
}

$directory = dirname(__DIR__).'/build/ai-evaluation';
if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
    fwrite(STDERR, "Cannot create evaluation directory.\n");
    exit(1);
}
file_put_contents(
    $directory.'/results.json',
    json_encode([
        'dataset_version' => $dataset['version'],
        'status' => 'automated_proxy_only_requires_human_review',
        'results' => $results,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n",
);
$csv = fopen($directory.'/results.csv', 'wb');
fputcsv($csv, [
    'id', 'category', 'question', 'expected_source', 'actual_sources', 'source_hit',
    'expected_contains', 'text_hit', 'answer', 'relevance_0_2', 'groundedness_0_2',
    'unsupported_claim_0_2', 'completeness_0_2', 'human_notes',
]);
foreach ($results as $row) {
    fputcsv($csv, [
        $row['id'], $row['category'], $row['question'], $row['expected_source'] ?? '',
        implode(' | ', $row['actual_sources']), $row['source_hit'] ? '1' : '0',
        $row['expected_contains'], $row['text_hit'] ? '1' : '0',
        $row['answer'], '', '', '', '', '',
    ]);
}
fclose($csv);
$sourceHits = count(array_filter($results, fn (array $r): bool => $r['source_hit']));
$textHits = count(array_filter($results, fn (array $r): bool => $r['text_hit']));
echo 'AI corpus cases: '.count($results).PHP_EOL;
echo 'Expected-source/fallback matches: '.$sourceHits.'/'.count($results).PHP_EOL;
echo 'Expected-text indicators: '.$textHits.'/'.count($results).PHP_EOL;
echo "This is not a groundedness or accuracy score; complete human review of the exported CSV.\n";
