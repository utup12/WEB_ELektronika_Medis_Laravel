<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Jobsheet | Praktik Elektronika Medis</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <style>
    .sheet-edition{margin:1.5rem 0 2rem;padding:1.25rem;border:1px solid #d9e3ef;border-radius:14px;background:#fff}
    .sheet-meta{color:#586779;font-size:.94rem}.sheet-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(255px,1fr));gap:1rem;margin-top:1rem}
    .sheet-card{display:block;padding:1.1rem;border:1px solid #d6e2f0;border-radius:12px;text-decoration:none;color:inherit;background:#f8fbff}
    .sheet-card:hover,.sheet-card:focus-visible{border-color:#2866aa;box-shadow:0 4px 18px #1234}
    .sheet-card strong{display:block;margin:.25rem 0}.sheet-card small{color:#4c6782}
    .sheet-card p{margin:.6rem 0 0;line-height:1.6}
    .sheet-note{border-left:4px solid #b87b16;padding:.8rem 1rem;background:#fff8e8;margin-top:1rem}
  </style>
</head>
<body>
<header class="site-header">
 <div class="identity-bar"><a class="uny-seal" href="{{ route('home') }}"><span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang UNY"></span></a><div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div></div>
 <div class="platform-bar"><a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a><button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button><nav class="main-nav" aria-label="Navigasi utama"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('materi') }}">Materi</a><a class="active" href="{{ route('jobsheet') }}">Jobsheet</a><a href="{{ route('praktikum') }}">Praktikum</a><a href="{{ route('evaluasi') }}">Evaluasi</a><a href="{{ route('laporan') }}">Unggah Laporan</a><a href="{{ route('asisten-ai') }}">Asisten AI</a><a href="{{ route('profil-dosen') }}">Profil Dosen</a><a href="{{ route('tentang') }}">Tentang</a></nav></div>
</header>
<main>
 <section class="page-hero"><p class="eyebrow">Referensi praktikum</p><h1>Katalog Jobsheet</h1><p>Telusuri topik menurut edisi panduan. Materi 2019 digunakan sebagai referensi sementara dan bukan pengganti arahan dosen pengampu.</p></section>
 <section class="page-content">
 <section class="sheet-edition" aria-labelledby="pilot-ppg-heading">
    <p class="sheet-meta">Kandidat pilot · materi latihan, belum jobsheet resmi</p>
    <h2 id="pilot-ppg-heading">Heart Rate / PPG</h2>
    <p>Pelajari prinsip PPG, kerjakan pre-lab, ikuti prosedur simulasi, dan catat pengamatan serta refleksi teknis. Gunakan jobsheet resmi dari dosen untuk kegiatan praktikum fisik.</p>
    <a class="button primary" href="{{ route('pilot.heart-rate') }}#pilot-jobsheet">Buka jobsheet pilot PPG</a>
  </section>
 @forelse ($editions as $edition)
  <section class="sheet-edition" aria-labelledby="edition-{{ $loop->index }}">
    <h2 id="edition-{{ $loop->index }}">{{ $edition['title'] }} ({{ $edition['year'] }})</h2>
    <p class="sheet-meta">Penyusun: {{ $edition['author'] ?? 'Tidak dicantumkan' }} · {{ count($edition['modules']) }} topik</p>
    <div class="sheet-note">{{ $edition['status'] ?? 'Status validasi belum dicantumkan.' }}</div>
    @foreach (collect($edition['modules'])->groupBy('group') as $group => $modules)
      <h3>{{ $group }}</h3>
      <div class="sheet-grid">
        @foreach ($modules as $module)
          <a class="sheet-card" href="{{ route('jobsheet.module', ['edition' => $edition['id'], 'module' => $module['slug']]) }}">
            <small>Jobsheet {{ $module['number'] ?? $loop->iteration }} · Halaman PDF {{ $module['pdf_page'] ?? '—' }}</small>
            <strong>{{ $module['title'] }}</strong>
            <p>{{ $module['summary'] }}</p>
          </a>
        @endforeach
      </div>
    @endforeach
  </section>
 @empty
  <div class="ai-boundary"><strong>Belum ada edisi jobsheet.</strong> Tambahkan manifest JSON yang valid ke folder resources/jobsheets.</div>
 @endforelse
 </section>
</main>
<script src="{{ asset('js/script.js') }}"></script>
</body></html>
