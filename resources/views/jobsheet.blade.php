<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Jobsheet | Praktik Elektronika Medis</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <style>
    .sheet-edition{margin:1.5rem 0 2rem;padding:1.35rem;border:1px solid #d9e3ef;border-radius:18px;background:#fff;box-shadow:0 12px 30px rgba(0,54,104,.06)}
    .sheet-meta{color:#586779;font-size:.94rem}.sheet-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(255px,1fr));gap:1rem;margin-top:1rem}
    .sheet-card{display:block;position:relative;overflow:hidden;padding:1.1rem;border:1px solid #d6e2f0;border-radius:15px;text-decoration:none;color:inherit;background:linear-gradient(145deg,#fff,#f2f8ff);transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease}
    .sheet-card:before{content:'';position:absolute;inset:0 0 auto;height:4px;background:linear-gradient(90deg,#004b93,#00a4a4,#f7c948);opacity:.85}.sheet-card:hover,.sheet-card:focus-visible{transform:translateY(-5px);border-color:#2866aa;box-shadow:0 15px 27px rgba(0,54,104,.16)}
    .sheet-card strong{display:block;margin:.25rem 0}.sheet-card small{color:#4c6782}
    .sheet-card p{margin:.6rem 0 0;line-height:1.6}
    .sheet-note{border-left:4px solid #b87b16;padding:.8rem 1rem;background:#fff8e8;margin-top:1rem}
    .sheet-card-head{display:flex;align-items:center;gap:.75rem;margin:.1rem 0 .55rem}.sheet-card-head small{flex:1}.sheet-card-icon{display:grid;place-items:center;width:42px;height:42px;flex:0 0 42px;border-radius:13px;background:linear-gradient(135deg,#e4f1ff,#fff4c7);color:#004b93;border:1px solid #d3e5f7;font-size:1.35rem;font-weight:800;box-shadow:inset 0 1px #fff}.sheet-card:hover .sheet-card-icon{background:linear-gradient(135deg,#004b93,#006db8);color:#fff}.sheet-edition h3{display:flex;align-items:center;gap:.55rem;margin-top:1.4rem}.sheet-edition h3:before{content:'⌁';display:grid;place-items:center;width:24px;height:24px;border-radius:7px;background:#e7f2fd;color:#004b93;font-weight:800}
    html[data-theme='dark'] .sheet-card-icon{background:#173f60;color:#f7d766;border-color:#45708e}html[data-theme='dark'] .sheet-edition h3:before{background:#173f60;color:#f7d766}
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
            @php($visuals = ['∿', 'Ω', '⏚', '⌁', '◌', '⟲'])
            <div class="sheet-card-head"><span class="sheet-card-icon" aria-hidden="true">{{ $visuals[($loop->iteration - 1) % count($visuals)] }}</span><small>Jobsheet {{ $module['number'] ?? $loop->iteration }} · Halaman PDF {{ $module['pdf_page'] ?? '—' }}</small></div>
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
