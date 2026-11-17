<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class JobsheetPracticeQuizzes
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $path = resource_path('jobsheets/practice-quizzes.json');

        if (! File::isFile($path)) {
            return [];
        }

        try {
            $decoded = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            Log::warning('Cannot parse practice quizzes JSON', ['error' => $exception->getMessage()]);

            return [];
        }

        if (! is_array($decoded) || ! is_array($decoded['modules'] ?? null)) {
            return [];
        }

        $modules = [];

        foreach ($decoded['modules'] as $module) {
            if (! is_array($module) || ! $this->isValidModule($module)) {
                continue;
            }

            $modules[] = $module;
        }

        return $modules;
    }

    /**
     * @param  array<mixed, mixed>  $module
     */
    private function isValidModule(array $module): bool
    {
        if (! is_string($module['slug'] ?? null)
            || ! is_int($module['number'] ?? null)
            || ! is_string($module['title'] ?? null)
            || ! is_string($module['group'] ?? null)
            || ! is_array($module['questions'] ?? null)) {
            return false;
        }

        foreach ($module['questions'] as $question) {
            if (! is_array($question)
                || ! is_int($question['id'] ?? null)
                || ! is_string($question['question'] ?? null)
                || ! is_array($question['options'] ?? null)
                || ! is_string($question['answer'] ?? null)
                || ! is_string($question['explanation'] ?? null)) {
                return false;
            }

            if (! in_array($question['answer'], ['a', 'b', 'c', 'd'], true)) {
                return false;
            }

            foreach (['a', 'b', 'c', 'd'] as $optionKey) {
                if (! is_string($question['options'][$optionKey] ?? null)) {
                    return false;
                }
            }
        }

        return true;
    }
}
