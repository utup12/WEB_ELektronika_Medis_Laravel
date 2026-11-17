<?php

namespace App\Http\Controllers;

use App\Models\ModuleProgress;
use App\Models\Report;
use App\Support\CloudflareR2Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ReportController extends Controller
{
    public function index(Request $request, CloudflareR2Storage $r2): View
    {
        $user = $request->user();
        abort_if($user === null, 401);

        $driveFolderUrl = $this->settingValue('report_drive_folder_url') ?: (string) env('REPORT_DRIVE_FOLDER_URL', '');
        $driveNote = $this->settingValue('report_drive_note') ?: 'Unggah PDF ke folder Google Drive dosen dengan format nama: NIM_Nama_JobsheetXX.pdf, lalu tempelkan tautan berkas/folder di bawah agar tercatat pada antrean koreksi dosen.';

        return view('laporan', [
            'reports' => $user->reports()->latest()->get(),
            'r2Configured' => $r2->isConfigured(),
            'driveFolderUrl' => $driveFolderUrl,
            'driveNote' => $driveNote,
        ]);
    }

    public function presign(Request $request, CloudflareR2Storage $r2): JsonResponse
    {
        $user = $request->user();
        abort_if($user === null, 401);

        if (! $r2->isConfigured()) {
            return response()->json([
                'message' => 'Penyimpanan Cloudflare R2 belum dikonfigurasi.',
            ], 503);
        }

        $data = $request->validate([
            'original_name' => ['required', 'string', 'max:255'],
            'content_type' => ['required', 'string', 'in:application/pdf'],
            'size' => ['required', 'integer', 'min:1', 'max:10485760'],
        ]);

        if (! str_ends_with(mb_strtolower($data['original_name']), '.pdf')) {
            return response()->json([
                'message' => 'Berkas harus berekstensi .pdf.',
            ], 422);
        }

        $key = $r2->generateReportKey($user->id, $data['original_name']);
        $uploadUrl = $r2->presignPutUrl($key, 900);

        return response()->json([
            'key' => $key,
            'upload_url' => $uploadUrl,
            'max_bytes' => 10485760,
        ]);
    }

    public function store(Request $request, CloudflareR2Storage $r2): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        abort_if($user === null, 401);

        if ($request->boolean('confirm_drive')) {
            $data = $request->validate([
                'module' => ['required', 'string', 'max:120'],
                'report_title' => ['required', 'string', 'max:180'],
            ]);

            $driveFolderUrl = $this->settingValue('report_drive_folder_url') ?: (string) env('REPORT_DRIVE_FOLDER_URL', '');
            if ($driveFolderUrl === '') {
                return back()->withErrors([
                    'confirm_drive' => 'Folder Google Drive belum diatur oleh dosen pengampu.',
                ])->withInput();
            }

            /** @var Report $report */
            $report = $user->reports()->create([
                'module' => $data['module'],
                'file_path' => $driveFolderUrl,
                'original_name' => trim($data['report_title']),
            ]);

            ModuleProgress::updateOrCreate(
                ['user_id' => $user->id, 'module' => $report->module, 'activity' => 'report_submitted'],
                ['completed_at' => now()],
            );

            return back()->with('success', 'Laporan berhasil dicatat pada folder Google Drive dosen dan menunggu koreksi.');
        }

        if ($request->filled('drive_url')) {
            $data = $request->validate([
                'module' => ['required', 'string', 'max:120'],
                'drive_url' => ['required', 'url:https', 'max:500'],
                'report_title' => ['required', 'string', 'max:180'],
            ]);

            $host = parse_url($data['drive_url'], PHP_URL_HOST);
            if (! is_string($host) || ! in_array($host, ['drive.google.com', 'docs.google.com'], true)) {
                return back()->withErrors([
                    'drive_url' => 'Gunakan tautan Google Drive yang valid (drive.google.com atau docs.google.com).',
                ])->withInput();
            }

            $label = trim($data['report_title']);

            /** @var Report $report */
            $report = $user->reports()->create([
                'module' => $data['module'],
                'file_path' => $data['drive_url'],
                'original_name' => $label,
            ]);

            ModuleProgress::updateOrCreate(
                ['user_id' => $user->id, 'module' => $report->module, 'activity' => 'report_submitted'],
                ['completed_at' => now()],
            );

            return back()->with('success', 'Tautan laporan Google Drive berhasil dikirim dan menunggu koreksi dosen.');
        }

        if ($r2->isConfigured() && $request->filled('r2_key')) {
            $data = $request->validate([
                'module' => ['required', 'string', 'max:120'],
                'r2_key' => ['required', 'string', 'max:255'],
                'original_name' => ['required', 'string', 'max:255'],
            ]);

            if (! $r2->isValidUserReportKey($user->id, $data['r2_key'])) {
                return response()->json([
                    'message' => 'Kunci berkas R2 tidak valid.',
                ], 422);
            }

            /** @var Report $report */
            $report = $user->reports()->create([
                'module' => $data['module'],
                'file_path' => $data['r2_key'],
                'original_name' => basename($data['original_name']),
            ]);

            ModuleProgress::updateOrCreate(
                ['user_id' => $user->id, 'module' => $report->module, 'activity' => 'report_submitted'],
                ['completed_at' => now()],
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Laporan berhasil dikirim ke Cloudflare R2 dan menunggu koreksi dosen.',
                    'redirect' => route('laporan'),
                ]);
            }

            return back()->with('success', 'Laporan berhasil dikirim ke Cloudflare R2 dan menunggu koreksi dosen.');
        }

        $data = $request->validate([
            'module' => ['required', 'string', 'max:120'],
            'report_title' => ['nullable', 'string', 'max:180'],
            'report' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        /** @var UploadedFile $file */
        $file = $data['report'];
        $storedPath = $file->store('reports/'.$user->id, 'public');
        abort_if($storedPath === false, 500, 'Gagal menyimpan berkas laporan.');

        $displayName = trim((string) ($data['report_title'] ?? ''));
        if ($displayName === '') {
            $displayName = $file->getClientOriginalName();
        }

        /** @var Report $report */
        $report = $user->reports()->create([
            'module' => $data['module'],
            'file_path' => $storedPath,
            'original_name' => $displayName,
        ]);

        ModuleProgress::updateOrCreate(
            ['user_id' => $user->id, 'module' => $report->module, 'activity' => 'report_submitted'],
            ['completed_at' => now()],
        );

        return back()->with('success', 'Laporan berhasil dikirim dan menunggu koreksi dosen.');
    }

    public function download(Request $request, Report $report, CloudflareR2Storage $r2): Response
    {
        $user = $request->user();
        abort_unless($user !== null && ($user->isLecturer() || $report->user_id === $user->id), 403);

        if (str_starts_with($report->file_path, 'https://')) {
            return redirect()->away($report->file_path);
        }

        if (Storage::disk('public')->exists($report->file_path)) {
            return Storage::disk('public')->response($report->file_path, $report->original_name, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        if ($r2->isConfigured()) {
            return redirect()->away($r2->presignGetUrl($report->file_path, 600));
        }

        abort(404, 'Berkas laporan tidak ditemukan.');
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
