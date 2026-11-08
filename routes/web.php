<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

// ===============================
// HALAMAN UTAMA
// ===============================
Route::get('/', function () {
    return view('home');
})->name('home');

// ===============================
// HALAMAN WEBSITE ELEKTRONIKA MEDIS
// ===============================
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

Route::get('/asisten-ai', [AiAssistantController::class, 'index'])->name('asisten-ai');
Route::post('/asisten-ai/chat', [AiAssistantController::class, 'store'])
    ->middleware('throttle:ai-chat')
    ->name('asisten-ai.chat');

Route::get('/panduan-praktikum', function () {
    return view('panduan-praktikum');
})->name('panduan-praktikum');

Route::get('/praktikum', function () {
    return view('praktikum');
})->name('praktikum');

Route::get('/pilot/heart-rate', function () {
    return view('pilot-heart-rate');
})->name('pilot.heart-rate');

Route::get('/profil-dosen', function () {
    return view('profil-dosen');
})->name('profil-dosen');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// ===============================
// TAMBAHAN HALAMAN
// ===============================
// Kalau nanti Anda punya halaman lain,
// tambahkan route dengan pola yang sama.
//
// Contoh:
//
// Route::get('/panduan-praktikum', function () {
//     return view('panduan-praktikum');
// })->name('panduan-praktikum');

// Laravel/Inertia team-scoped dashboard
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
    });

// Laravel/Inertia settings routes
require __DIR__.'/settings.php';
