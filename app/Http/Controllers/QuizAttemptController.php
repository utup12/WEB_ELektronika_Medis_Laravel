<?php

namespace App\Http\Controllers;

use App\Models\ModuleProgress;
use App\Support\JobsheetPracticeQuizzes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizAttemptController extends Controller
{
    public function index(Request $request, JobsheetPracticeQuizzes $quizzes): View
    {
        $user = $request->user();
        $attempts = $user !== null
            ? $user->quizAttempts()->latest('submitted_at')->get()
            : collect();

        return view('evaluasi', [
            'attempts' => $attempts,
            'practiceQuizzes' => $quizzes->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if($user === null, 401);

        $answers = $request->validate([
            'safety' => ['required', 'in:correct,wrong'],
            'signal' => ['required', 'in:correct,wrong'],
            'report' => ['required', 'in:correct,wrong'],
        ]);
        $score = collect($answers)->filter(fn (string $answer): bool => $answer === 'correct')->count();

        $user->quizAttempts()->create([
            'score' => $score,
            'total' => 3,
            'answers' => $answers,
            'submitted_at' => now(),
        ]);

        ModuleProgress::updateOrCreate(
            ['user_id' => $user->id, 'module' => 'Kesiapan Praktikum', 'activity' => 'prelab_completed'],
            ['completed_at' => now()],
        );

        return back()->with('success', "Hasil evaluasi tersimpan: {$score}/3.");
    }
}
