<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentProgressController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('progres-saya', [
            'progress' => $user->moduleProgress()->latest('completed_at')->get(),
            'reports' => $user->reports()->latest()->get(),
            'latestAttempt' => $user->quizAttempts()->latest('submitted_at')->first(),
        ]);
    }
}
