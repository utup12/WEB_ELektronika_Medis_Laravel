<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class LecturerDashboardController extends Controller
{
    public function index(): View
    {
        return view('dosen-dashboard', [
            'studentCount' => User::query()->where('role', 'student')->count(),
            'pendingReports' => Report::query()->where('status', 'submitted')->count(),
            'attemptCount' => QuizAttempt::query()->count(),
            'reports' => Report::query()->with('user')->latest()->take(20)->get(),
            'driveFolderUrl' => $this->settingValue('report_drive_folder_url') ?: (string) config('services.reports.drive_folder_url', ''),
            'driveNote' => $this->settingValue('report_drive_note') ?: '',
        ]);
    }

    public function updateDriveFolder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'drive_folder_url' => ['nullable', 'url:https', 'max:500'],
            'drive_note' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($data['drive_folder_url'])) {
            $host = parse_url($data['drive_folder_url'], PHP_URL_HOST);
            if (! is_string($host) || ! in_array($host, ['drive.google.com', 'docs.google.com'], true)) {
                return back()->withErrors([
                    'drive_folder_url' => 'Gunakan tautan Google Drive yang valid (drive.google.com).',
                ])->withInput();
            }
        }

        foreach ([
            'report_drive_folder_url' => $data['drive_folder_url'] ?? '',
            'report_drive_note' => $data['drive_note'] ?? '',
        ] as $key => $value) {
            DB::table('platform_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now(), 'created_at' => now()],
            );
        }

        return back()->with('success', 'Tautan folder Google Drive pengumpulan laporan berhasil disimpan.');
    }

    public function grade(Request $request, Report $report): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:revision,graded'],
            'score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'feedback' => ['nullable', 'string', 'max:2000'],
        ]);
        $report->update($data);

        return back()->with('success', 'Koreksi laporan tersimpan.');
    }

    private function settingValue(string $key): ?string
    {
        try {
            $value = DB::table('platform_settings')->where('key', $key)->value('value');

            return is_string($value) ? $value : null;
        } catch (Throwable) {
            return null;
        }
    }
}
