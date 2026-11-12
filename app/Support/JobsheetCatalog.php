<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class JobsheetCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function editions(): array
    {
        $directory = resource_path('jobsheets');

        if (! File::isDirectory($directory)) {
            return [];
        }

        $editions = [];

        foreach (File::glob($directory.'/*.json') ?: [] as $path) {
            try {
                $data = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

                if (! is_array($data) || ! $this->validEdition($data)) {
                    Log::warning('Invalid jobsheet edition manifest', ['file' => basename($path)]);

                    continue;
                }

                $data['modules'] = array_values(array_filter(
                    $data['modules'],
                    fn (mixed $module): bool => $this->validModule($module),
                ));

                $editions[] = $data;
            } catch (\JsonException $exception) {
                Log::warning('Cannot parse jobsheet manifest', [
                    'file' => basename($path),
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        usort($editions, fn (array $a, array $b): int => ($b['year'] <=> $a['year']) ?: strcmp($a['title'], $b['title']));

        return $editions;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function module(string $editionId, string $slug): ?array
    {
        foreach ($this->editions() as $edition) {
            if ($edition['id'] !== $editionId) {
                continue;
            }

            foreach ($edition['modules'] as $module) {
                if ($module['slug'] === $slug) {
                    return ['edition' => $edition, 'module' => $module];
                }
            }
        }

        return null;
    }

    private function validEdition(array $data): bool
    {
        return isset($data['id'], $data['title'], $data['year'], $data['modules'])
            && is_string($data['id']) && preg_match('/^[a-z0-9-]+$/', $data['id']) === 1
            && is_string($data['title']) && is_numeric($data['year'])
            && is_array($data['modules']);
    }

    private function validModule(mixed $module): bool
    {
        return is_array($module)
            && isset($module['slug'], $module['title'], $module['group'], $module['summary'])
            && is_string($module['slug']) && preg_match('/^[a-z0-9-]+$/', $module['slug']) === 1
            && is_string($module['title']) && is_string($module['group'])
            && is_string($module['summary']);
    }
}
