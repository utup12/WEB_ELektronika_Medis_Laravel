<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\View\View;

class LecturerManagementController extends Controller
{
    private const ATTENDANCE_ROSTER_SIZE = 50;

    private const ATTENDANCE_STATUSES = ['present', 'permission', 'sick', 'absent'];

    private const TRAINER_KIT_COUNT = 8;

    public function classes(Request $request): View
    {
        return view('dosen-manajemen', [
            'section' => 'classes',
            'classes' => $this->ownedClasses($request)->latest()->get(),
            'students' => DB::table('users')->where('role', 'student')->orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    public function storeClass(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'alpha_dash', 'max:30', 'unique:classrooms'],
            'semester' => ['nullable', 'string', 'max:80'],
        ]);

        DB::table('classrooms')->insert([
            ...$data,
            'lecturer_id' => $request->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Kelas dibuat.');
    }

    public function addMember(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'classroom_id' => ['required', $this->ownClassroomRule($request)],
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'student')],
            'group_name' => ['nullable', 'string', 'max:80'],
        ]);

        DB::table('classroom_members')->updateOrInsert(
            ['classroom_id' => $data['classroom_id'], 'user_id' => $data['user_id']],
            ['group_name' => $data['group_name'] ?? null, 'updated_at' => now(), 'created_at' => now()],
        );

        return back()->with('success', 'Mahasiswa/kelompok diperbarui.');
    }

    public function attendance(Request $request): View
    {
        $ownedClassIds = $this->ownedClasses($request)->pluck('id');

        return view('dosen-presensi', [
            'classes' => $this->ownedClasses($request)->get(),
            'sessions' => DB::table('attendance_sessions')
                ->leftJoin('classrooms', 'classrooms.id', '=', 'attendance_sessions.classroom_id')
                ->where(fn ($query) => $query
                    ->whereNull('attendance_sessions.classroom_id')
                    ->orWhereIn('attendance_sessions.classroom_id', $ownedClassIds))
                ->select('attendance_sessions.*', 'classrooms.name as classroom_name')
                ->orderByDesc('opens_at')
                ->limit(100)
                ->get(),
        ]);
    }

    public function storeAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'classroom_id' => ['nullable', $this->ownClassroomRule($request)],
            'module' => ['required', 'string', 'max:120'],
            // attendance_sessions.code is varchar(12); students submit it with the same limit.
            'code' => ['required', 'string', 'max:12'],
            'opens_at' => ['required', 'date'],
            'closes_at' => ['required', 'date', 'after:opens_at'],
            'student_name' => ['required', 'array', 'size:'.self::ATTENDANCE_ROSTER_SIZE],
            'student_name.*' => ['required', 'string', 'max:120'],
            'status' => ['required', 'array', 'size:'.self::ATTENDANCE_ROSTER_SIZE],
            'status.*' => ['required', Rule::in(self::ATTENDANCE_STATUSES)],
        ]);

        $code = strtoupper($data['code']);

        DB::transaction(function () use ($request, $data, $code): void {
            $sessionId = DB::table('attendance_sessions')->insertGetId([
                'classroom_id' => $data['classroom_id'] ?? null,
                'module' => $data['module'],
                'code' => $code,
                'opens_at' => $data['opens_at'],
                'closes_at' => $data['closes_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('attendance_manual_entries')->insert(
                collect($data['student_name'])
                    ->map(fn (string $name, int|string $index): array => [
                        'attendance_session_id' => $sessionId,
                        'student_name' => $name,
                        'status' => $data['status'][$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                    ->values()
                    ->all(),
            );

            DB::table('announcements')->insert([
                'lecturer_id' => $request->user()->id,
                'classroom_id' => $data['classroom_id'] ?? null,
                'title' => 'Token Presensi: '.$data['module'],
                'body' => 'Token presensi SIAKAD untuk '.$data['module'].': '.$code.'. Silakan salin token ini dan masukkan ke SIAKAD masing-masing sebelum sesi ditutup.',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Token dan presensi manual berhasil diterbitkan.');
    }

    public function announcements(Request $request): View
    {
        return view('dosen-manajemen', [
            'section' => 'announcements',
            'classes' => $this->ownedClasses($request)->get(),
            'announcements' => DB::table('announcements')
                ->where('lecturer_id', $request->user()->id)
                ->latest()
                ->limit(50)
                ->get(),
        ]);
    }

    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'classroom_id' => ['nullable', $this->ownClassroomRule($request)],
            'title' => ['required', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        DB::table('announcements')->insert([
            ...$data,
            'lecturer_id' => $request->user()->id,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pengumuman diterbitkan.');
    }

    public function trainerKit(): View
    {
        // One idempotent query instead of eight writes on every page view.
        DB::table('trainer_kits')->insertOrIgnore(
            collect(range(1, self::TRAINER_KIT_COUNT))
                ->map(fn (int $number): array => [
                    'module_number' => $number,
                    'title' => 'Trainer Kit '.$number,
                    'status' => 'draft',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
                ->all(),
        );

        return view('dosen-manajemen', [
            'section' => 'trainer',
            'kits' => DB::table('trainer_kits')->orderBy('module_number')->get(),
        ]);
    }

    public function updateTrainerKit(Request $request, int $kit): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'status' => ['required', 'in:draft,available,maintenance'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        abort_unless(DB::table('trainer_kits')->where('id', $kit)->exists(), 404);

        DB::table('trainer_kits')->where('id', $kit)->update([...$data, 'updated_at' => now()]);

        return back()->with('success', 'Status trainer kit diperbarui.');
    }

    public function questions(Request $request): View
    {
        return view('dosen-manajemen', [
            'section' => 'questions',
            'questions' => DB::table('question_bank')
                ->where('lecturer_id', $request->user()->id)
                ->latest()
                ->limit(100)
                ->get(),
        ]);
    }

    public function storeQuestion(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'module' => ['required', 'string', 'max:120'],
            'question' => ['required', 'string', 'max:2000'],
            'options_text' => ['required', 'string', 'max:2000'],
            'correct_answer' => ['required', 'string', 'max:255'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $options = array_values(array_filter(array_map('trim', preg_split('/\R/', $data['options_text']) ?: [])));

        DB::table('question_bank')->insert([
            'lecturer_id' => $request->user()->id,
            'module' => $data['module'],
            'question' => $data['question'],
            'options' => json_encode($options, JSON_THROW_ON_ERROR),
            'correct_answer' => $data['correct_answer'],
            'points' => $data['points'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Soal ditambahkan.');
    }

    public function monitoring(): View
    {
        return view('dosen-manajemen', [
            'section' => 'monitoring',
            'students' => DB::table('users')
                ->where('users.role', 'student')
                ->leftJoin('reports', 'reports.user_id', '=', 'users.id')
                ->leftJoin('quiz_attempts', 'quiz_attempts.user_id', '=', 'users.id')
                ->select(
                    'users.name',
                    'users.email',
                    DB::raw('count(distinct reports.id) as reports_count'),
                    DB::raw('count(distinct quiz_attempts.id) as quizzes_count'),
                )
                ->groupBy('users.id', 'users.name', 'users.email')
                ->orderBy('users.name')
                ->get(),
        ]);
    }

    /**
     * Classrooms that belong to the signed-in lecturer.
     */
    private function ownedClasses(Request $request): Builder
    {
        return DB::table('classrooms')->where('lecturer_id', $request->user()->id);
    }

    /**
     * A lecturer may only reference their own classrooms (prevents IDOR across lecturers).
     */
    private function ownClassroomRule(Request $request): Exists
    {
        return Rule::exists('classrooms', 'id')->where('lecturer_id', $request->user()->id);
    }
}
