<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description ?? 'Platform praktikum Elektronika Medis: materi, jobsheet, evaluasi, dan pelaporan untuk mahasiswa dan dosen UNY.' }}">
    <meta name="theme-color" content="#0b2a4a">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png"><title>{{ $title ?? 'Praktik Elektronika Medis' }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link rel="stylesheet" href="{{ asset('css/identity.css') }}"><link rel="stylesheet" href="{{ asset('css/pages.css') }}">
<link rel="stylesheet" href="/css/a11y.css">
</head>
<body><a class="skip-link" href="#main-content">Lewati ke konten utama</a>
<header class="site-header"><div class="identity-bar"><a class="uny-seal" href="{{ route('home') }}"><span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang UNY"></span></a><div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div></div>
<div class="platform-bar"><a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a><button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button><nav class="main-nav" aria-label="Navigasi utama"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('materi') }}">Materi</a><a href="{{ route('praktikum') }}">Praktikum</a><a href="{{ route('monitor-trainer') }}">Monitor Heart Rate (BLE)</a><a href="{{ route('evaluasi') }}">Evaluasi</a><a href="{{ route('laporan') }}">Unggah Laporan</a><a href="{{ route('asisten-ai') }}">Asisten AI</a><a href="{{ route('profil-dosen') }}">Profil Dosen</a>
@auth
    @if(auth()->user()->isLecturer())
        <a href="{{ route('dosen.dashboard') }}">Dashboard Dosen</a>
    @else
        <a href="{{ route('student.progress') }}">Progres Saya</a><a href="{{ route('student.notes') }}">Catatan</a>
    @endif
@endauth
</nav>
@auth
    <form class="logout-form" method="POST" action="{{ route('keluar') }}">@csrf<button type="submit">Keluar</button></form>
@else
    <a class="header-login" href="{{ route('masuk') }}">Masuk</a>
@endauth
</div></header><main id="main-content" tabindex="-1">{{ $slot }}</main><script src="{{ asset('js/script.js') }}"></script></body></html>
