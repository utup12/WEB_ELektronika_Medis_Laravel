<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LecturerDashboardController extends Controller
{
    public function index(): View
    {
        return view('dosen-dashboard', [
            'studentCount' => User::query()->where('role', 'student')->count(),
            'pendingReports' => Report::query()->where('status', 'submitted')->count(),
            'attemptCount' => QuizAttempt::query()->count(),
            'reports' => Report::query()->with('user')->latest()->take(20)->get(),
        ]);
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
}
