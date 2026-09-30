<?php

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

Route::get('/asisten-ai', function () {
    return view('asisten-ai');
})->name('asisten-ai');

Route::get('/panduan-praktikum', function () {
    return view('panduan-praktikum');
})->name('panduan-praktikum');

Route::get('/praktikum', function () {
    return view('praktikum');
})->name('praktikum');

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
