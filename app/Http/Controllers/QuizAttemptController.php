<?php

namespace App\Http\Controllers;

use App\Models\ModuleProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizAttemptController extends Controller
{
    public function index(Request $request): View
    {
        return view('evaluasi', ['attempts' => $request->user()->quizAttempts()->latest('submitted_at')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $answers = $request->validate([
            'safety' => ['required', 'in:correct,wrong'],
            'signal' => ['required', 'in:correct,wrong'],
            'report' => ['required', 'in:correct,wrong'],
        ]);
        $score = collect($answers)->filter(fn (string $answer): bool => $answer === 'correct')->count();

        $request->user()->quizAttempts()->create([
            'score' => $score,
            'total' => 3,
            'answers' => $answers,
            'submitted_at' => now(),
        ]);

        ModuleProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'module' => 'Kesiapan Praktikum', 'activity' => 'prelab_completed'],
            ['completed_at' => now()],
        );

        return back()->with('success', "Hasil evaluasi tersimpan: {$score}/3.");
    }
}
