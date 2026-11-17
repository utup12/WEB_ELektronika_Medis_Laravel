<?php

namespace App\Http\Controllers;

use App\Models\ModuleProgress;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('laporan', ['reports' => $request->user()->reports()->latest()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'module' => ['required', 'string', 'max:120'],
            'report' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $file = $data['report'];
        $report = $request->user()->reports()->create([
            'module' => $data['module'],
            'file_path' => $file->store('reports/'.$request->user()->id, 'public'),
            'original_name' => $file->getClientOriginalName(),
        ]);

        ModuleProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'module' => $report->module, 'activity' => 'report_submitted'],
            ['completed_at' => now()],
        );

        return back()->with('success', 'Laporan berhasil dikirim dan menunggu koreksi dosen.');
    }
}
