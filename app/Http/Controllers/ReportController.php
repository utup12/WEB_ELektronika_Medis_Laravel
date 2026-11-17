<?php

namespace App\Http\Controllers;

use App\Models\ModuleProgress;
use App\Models\Report;
use App\Support\CloudflareR2Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index(Request $request, CloudflareR2Storage $r2): View
    {
        $user = $request->user();
        abort_if($user === null, 401);

        return view('laporan', [
            'reports' => $user->reports()->latest()->get(),
            'r2Configured' => $r2->isConfigured(),
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
            'report' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        /** @var UploadedFile $file */
        $file = $data['report'];
        $storedPath = $file->store('reports/'.$user->id, 'public');
        abort_if($storedPath === false, 500, 'Gagal menyimpan berkas laporan.');

        /** @var Report $report */
        $report = $user->reports()->create([
            'module' => $data['module'],
            'file_path' => $storedPath,
            'original_name' => $file->getClientOriginalName(),
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
}
