<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ $title ?? 'Praktik Elektronika Medis' }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link rel="stylesheet" href="{{ asset('css/identity.css') }}"><link rel="stylesheet" href="{{ asset('css/pages.css') }}">
</head>
<body>
<header class="site-header"><div class="identity-bar"><a class="uny-seal" href="{{ route('home') }}"><span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang UNY"></span></a><div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div></div>
<div class="platform-bar"><a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a><button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button><nav class="main-nav" aria-label="Navigasi utama"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('materi') }}">Materi</a><a href="{{ route('praktikum') }}">Praktikum</a><a href="{{ route('evaluasi') }}">Evaluasi</a><a href="{{ route('laporan') }}">Unggah Laporan</a><a href="{{ route('asisten-ai') }}">Asisten AI</a><a href="{{ route('profil-dosen') }}">Profil Dosen</a>
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
</div></header><main>{{ $slot }}</main><script src="{{ asset('js/script.js') }}"></script></body></html>
