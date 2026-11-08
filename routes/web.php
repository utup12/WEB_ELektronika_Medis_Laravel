
<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| HALAMAN WEBSITE ELEKTRONIKA MEDIS
|--------------------------------------------------------------------------
*/

Route::get('/materi', function () {
    return view('materi');
})->name('materi');

Route::get('/jobsheet', function () {
    return view('jobsheet');
})->name('jobsheet');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

Route::get('/evaluasi', function () {
    return view('evaluasi');
})->name('evaluasi');

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
| PANDUAN DAN PRAKTIKUM
|--------------------------------------------------------------------------
*/

Route::get('/panduan-praktikum', function () {
    return view('panduan-praktikum');
})->name('panduan-praktikum');

Route::get('/praktikum', function () {
    return view('praktikum');
})->name('praktikum');

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
