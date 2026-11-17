<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\LocalAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LecturerDashboardController;
use App\Http\Controllers\LecturerManagementController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentProgressController;
use App\Models\ModuleProgress;
use App\Http\Middleware\EnsureTeamMembership;
use App\Support\JobsheetCatalog;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/masuk', [LocalAuthController::class, 'loginForm'])->name('masuk');
Route::get('/masuk/{role}', [LocalAuthController::class, 'roleLoginForm'])->whereIn('role', ['student', 'lecturer'])->name('masuk.role');
Route::post('/masuk', [LocalAuthController::class, 'login'])->name('masuk.store');
Route::get('/daftar', [LocalAuthController::class, 'registerForm'])->name('daftar');
Route::post('/daftar', [LocalAuthController::class, 'register'])->name('daftar.store');
Route::post('/keluar', [LocalAuthController::class, 'logout'])->middleware('auth')->name('keluar');

/*
|--------------------------------------------------------------------------
| HALAMAN WEBSITE ELEKTRONIKA MEDIS
|--------------------------------------------------------------------------
*/

Route::get('/materi', function () {
    return view('materi');
})->name('materi');

Route::get('/jobsheet', function () {
    return redirect()->to(route('praktikum', [], false).'#jobsheet');
})->name('jobsheet');

Route::get('/jobsheet/{edition}/{module}', function (
    string $edition,
    string $module,
    JobsheetCatalog $catalog
) {
    $found = $catalog->module($edition, $module);

    abort_if($found === null, 404);

    if (auth()->check()) {
        ModuleProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'module' => $module, 'activity' => 'jobsheet_read'],
            ['completed_at' => now()],
        );
    }

    return view('jobsheet-module', $found);
})->where(['edition' => '[a-z0-9-]+', 'module' => '[a-z0-9-]+'])->name('jobsheet.module');

Route::get('/evaluasi', [QuizAttemptController::class, 'index'])->name('evaluasi');

Route::middleware('auth')->group(function () {
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::post('/laporan/presign', [ReportController::class, 'presign'])->name('laporan.presign');
    Route::post('/laporan', [ReportController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{report}/berkas', [ReportController::class, 'download'])->name('laporan.download');
    Route::post('/evaluasi', [QuizAttemptController::class, 'store'])->name('evaluasi.store');
    Route::get('/progres-saya', StudentProgressController::class)->name('student.progress');
    Route::get('/presensi', [StudentAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/presensi', [StudentAttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/catatan-mahasiswa', function () { return view('catatan-mahasiswa'); })->name('student.notes');
});

Route::get('/monitor-trainer', function () {
    return view('monitor-trainer');
})->name('monitor-trainer');

/*
|--------------------------------------------------------------------------
| ASISTEN AI
|--------------------------------------------------------------------------
*/

Route::get('/asisten-ai', [
    AiAssistantController::class,
    'index',
])->name('asisten-ai');

Route::post('/asisten-ai/chat', [
    AiAssistantController::class,
    'store',
])
    ->middleware('throttle:ai-chat')
    ->name('asisten-ai.chat');

/*
|--------------------------------------------------------------------------
| PRAKTIKUM DAN PANDUAN
|--------------------------------------------------------------------------
*/

Route::get('/panduan-praktikum', function () {
    return redirect()->to(route('praktikum', [], false).'#panduan-praktikum');
})->name('panduan-praktikum');

Route::get('/praktikum', function (JobsheetCatalog $catalog) {
    return view('praktikum', ['editions' => $catalog->editions()]);
})->name('praktikum');

Route::get('/praktikum/trainer-kit', function () {
    return view('trainer-kit');
})->name('praktikum.trainer-kit');

/*
|--------------------------------------------------------------------------
| PILOT HEART RATE
|--------------------------------------------------------------------------
*/

Route::get('/pilot/heart-rate', function () {
    return view('pilot-heart-rate');
})->name('pilot.heart-rate');

/*
|--------------------------------------------------------------------------
| INFORMASI
|--------------------------------------------------------------------------
*/

Route::get('/profil-dosen', function () {
    return view('profil-dosen');
})->name('profil-dosen');

Route::middleware(['auth', 'lecturer'])->group(function () {
    Route::get('/dosen', [LecturerDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::patch('/dosen/laporan/{report}', [LecturerDashboardController::class, 'grade'])->name('dosen.reports.grade');
    Route::get('/dosen/kelas', [LecturerManagementController::class, 'classes'])->name('dosen.classes');
    Route::post('/dosen/kelas', [LecturerManagementController::class, 'storeClass'])->name('dosen.classes.store');
    Route::post('/dosen/kelas/anggota', [LecturerManagementController::class, 'addMember'])->name('dosen.classes.members');
    Route::get('/dosen/presensi', [LecturerManagementController::class, 'attendance'])->name('dosen.attendance');
    Route::post('/dosen/presensi', [LecturerManagementController::class, 'storeAttendance'])->name('dosen.attendance.store');
    Route::get('/dosen/pengumuman', [LecturerManagementController::class, 'announcements'])->name('dosen.announcements');
    Route::post('/dosen/pengumuman', [LecturerManagementController::class, 'storeAnnouncement'])->name('dosen.announcements.store');
    Route::get('/dosen/trainer-kit', [LecturerManagementController::class, 'trainerKit'])->name('dosen.trainer');
    Route::patch('/dosen/trainer-kit/{kit}', [LecturerManagementController::class, 'updateTrainerKit'])->name('dosen.trainer.update');
    Route::get('/dosen/bank-soal', [LecturerManagementController::class, 'questions'])->name('dosen.questions');
    Route::post('/dosen/bank-soal', [LecturerManagementController::class, 'storeQuestion'])->name('dosen.questions.store');
    Route::get('/dosen/monitoring', [LecturerManagementController::class, 'monitoring'])->name('dosen.monitoring');
});

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

/*
|--------------------------------------------------------------------------
| DASHBOARD UMUM
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| DASHBOARD KHUSUS TIM
|--------------------------------------------------------------------------
*/

Route::prefix('{current_team}')
    ->middleware([
        'auth',
        'verified',
        EnsureTeamMembership::class,
    ])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)
            ->name('teams.dashboard');
    });

/*
|--------------------------------------------------------------------------
| SETTINGS
|--------------------------------------------------------------------------
*/

require __DIR__.'/settings.php';
