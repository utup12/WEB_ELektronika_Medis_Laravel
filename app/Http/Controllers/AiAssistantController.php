<?php

namespace App\Http\Controllers;

use App\Actions\AnswerPracticeQuestion;
use App\Http\Requests\ChatWithAssistantRequest;
use App\Models\AiConversationHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class AiAssistantController extends Controller
{
    public function index(Request $request): View
    {
        $ownerKey = $this->resolveOwnerKey($request);
        $limit = AiConversationHistory::LIMIT_PER_PERSON;
        $savedHistory = collect();

        try {
            $savedHistory = AiConversationHistory::query()
                ->where('owner_key', $ownerKey)
                ->orderBy('id')
                ->get(['id', 'question', 'answer', 'sources', 'created_at']);
        } catch (Throwable) {
            $savedHistory = collect();
        }

        $memoryCount = $savedHistory->count();

        return view('asisten-ai', [
            'savedHistory' => $savedHistory,
            'memoryCount' => $memoryCount,
            'memoryLimit' => $limit,
            'memoryFull' => $memoryCount >= $limit,
        ]);
    }

    public function store(
        ChatWithAssistantRequest $request,
        AnswerPracticeQuestion $answerPracticeQuestion,
    ): JsonResponse {
        /** @var array{message: string} $validated */
        $validated = $request->validated();
        $user = $request->user();
        $ownerKey = $this->resolveOwnerKey($request);
        $limit = AiConversationHistory::LIMIT_PER_PERSON;

        $currentCount = 0;
        $lastQuestion = null;
        $dbAvailable = true;

        try {
            $currentCount = AiConversationHistory::query()
                ->where('owner_key', $ownerKey)
                ->count();

            if ($currentCount >= $limit) {
                $warning = "Memori percakapan Anda sudah penuh ({$limit}/{$limit}). Klik Reset Memori untuk menyimpan jawaban baru.";

                return response()->json([
                    'answer' => "Memori percakapan Anda sudah penuh ({$limit}/{$limit}). Silakan klik tombol Reset Memori untuk menghapus riwayat lama sebelum bertanya lagi.",
                    'sources' => [],
                    'memory_full' => true,
                    'memory_warning' => $warning,
                    'memory' => $this->memoryPayload($limit, $limit),
                ]);
            }

            $lastQuestion = AiConversationHistory::query()
                ->where('owner_key', $ownerKey)
                ->latest('id')
                ->value('question');
        } catch (Throwable) {
            $dbAvailable = false;
        }

        $result = $answerPracticeQuestion->handle(
            $validated['message'],
            (bool) $user?->isLecturer(),
            $user?->id,
            is_string($lastQuestion) ? $lastQuestion : null,
        );

        $newCount = $currentCount;

        if ($dbAvailable && empty($result['memoryForm'])) {
            try {
                AiConversationHistory::query()->create([
                    'owner_key' => $ownerKey,
                    'user_id' => $user?->id,
                    'question' => $validated['message'],
                    'answer' => $result['answer'],
                    'sources' => $result['sources'] ?? [],
                ]);

                $newCount = AiConversationHistory::query()
                    ->where('owner_key', $ownerKey)
                    ->count();
            } catch (Throwable) {
                // Tetap kembalikan jawaban AI lokal meskipun penyimpanan gagal.
            }
        }

        $memory = $this->memoryPayload($newCount, $limit);
        $response = [
            ...$result,
            'memory' => $memory,
        ];

        if ($memory['is_full']) {
            $response['memory_warning'] = "Memori percakapan Anda sudah penuh ({$limit}/{$limit}). Klik Reset Memori untuk menyimpan jawaban baru.";
        }

        return response()->json($response);
    }

    public function reset(Request $request): JsonResponse
    {
        $ownerKey = $this->resolveOwnerKey($request);
        $limit = AiConversationHistory::LIMIT_PER_PERSON;

        try {
            AiConversationHistory::query()
                ->where('owner_key', $ownerKey)
                ->delete();
        } catch (Throwable) {
            return response()->json([
                'ok' => false,
                'message' => 'Penyimpanan memori sedang tidak tersedia.',
                'memory' => $this->memoryPayload(0, $limit),
            ], 503);
        }

        return response()->json([
            'ok' => true,
            'memory' => $this->memoryPayload(0, $limit),
        ]);
    }

    private function resolveOwnerKey(Request $request): string
    {
        $user = $request->user();

        if ($user !== null) {
            return 'user:'.$user->id;
        }

        $guestKey = $request->session()->get('ai_guest_key');

        if (! is_string($guestKey) || $guestKey === '') {
            $guestKey = (string) Str::uuid();
            $request->session()->put('ai_guest_key', $guestKey);
        }

        return 'guest:'.$guestKey;
    }

    /**
     * @return array{used: int, limit: int, remaining: int, is_full: bool}
     */
    private function memoryPayload(int $used, int $limit): array
    {
        $clampedUsed = max(0, min($used, $limit));

        return [
            'used' => $clampedUsed,
            'limit' => $limit,
            'remaining' => max(0, $limit - $clampedUsed),
            'is_full' => $clampedUsed >= $limit,
        ];
    }
}
