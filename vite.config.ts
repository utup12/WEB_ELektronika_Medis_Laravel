import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import babel from '@rolldown/plugin-babel';
import tailwindcss from '@tailwindcss/vite';
import react, { reactCompilerPreset } from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig, lazyPlugins } from 'vite-plus';

export default defineConfig({
    plugins: lazyPlugins(() => [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        inertia(),
        react(),
        babel({
            presets: [reactCompilerPreset()],
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
    ]),
    server: {
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/vendor/**',
            ],
        },
    },
    lint: {
        ignorePatterns: [
            'vendor/**',
            'node_modules/**',
            'public/**',
            'bootstrap/ssr/**',
            'tailwind.config.js',
            'resources/js/actions/**',
            'resources/js/components/ui/*',
            'resources/js/routes/**',
            'resources/js/wayfinder/**',
        ],
        options: {
            denyWarnings: true,
            typeAware: true,
        },
    },
    fmt: {
        printWidth: 80,
        tabWidth: 4,
        singleQuote: true,
        semi: true,
        singleAttributePerLine: false,
        htmlWhitespaceSensitivity: 'css',
        ignorePatterns: [
            '.github/**',
            'composer.json',
            'resources/js/components/ui/*',
            'resources/views/mail/*',
            'public/js/jobsheet-observations.js',
            'public/js/jobsheet-frequency-chart.js',
            'public/js/jobsheet-workspace.js',
            'public/js/jobsheet-data-quality.js',
            'public/js/student-profile.js',
            'public/js/script.js',
            'public/css/student-profile.css',
            'public/css/jobsheet-learning.css',
            // Legacy GitHub Pages prototype; Laravel is the active target.
            'pilot-heart-rate/index.html',
            'docs/AI_SCOPE.md',
            'docs/UJI_COBA_MEDIA_PRAKTIKUM.md',
            'docs/RELEASE_RUNBOOK.md',
            'docs/PPG_PILOT_ACCEPTANCE_CHECKLIST.md',
            'docs/BLE_SMARTWATCH_TEST_LOG.md',
            'docs/AI_BASELINE_EVALUATION_PROTOCOL.md',
            'docs/BOUNDED_RAG_NEXT_STAGE.md',
            'docs/PR_ADI_FOLLOWUP_2026-11-14.md',
            'resources/ai-evaluation/baseline-cases.json',
            'scripts/test_pilot_client.mjs',
        ],
        sortTailwindcss: {
            functions: ['clsx', 'cn', 'cva'],
            stylesheet: 'resources/css/app.css',
        },
    },
});
