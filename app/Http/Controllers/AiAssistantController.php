<?php

namespace App\Http\Controllers;

use App\Actions\AnswerPracticeQuestion;
use App\Http\Requests\ChatWithAssistantRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AiAssistantController extends Controller
{
    public function index(): View
    {
        return view('asisten-ai');
    }

    public function store(
        ChatWithAssistantRequest $request,
        AnswerPracticeQuestion $answerPracticeQuestion,
    ): JsonResponse {
        /** @var array{message: string} $validated */
        $validated = $request->validated();

        return response()->json(
            $answerPracticeQuestion->handle($validated['message']),
        );
    }
}
