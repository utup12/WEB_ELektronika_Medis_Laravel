<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Panduan pelaksanaan Praktik Elektronika Medis.">
  <title>Panduan Praktikum | Praktik Elektronika Medis</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <link rel="stylesheet" href="{{ asset('css/visual-enhancements.css') }}">
</head>
<body>
  <header class="site-header">
    <div class="identity-bar">
      <a class="uny-seal" href="{{ route('home') }}" aria-label="Kembali ke Beranda"><span><img src="{{ asset('assets/logo-uny.png') }}" alt="Lambang Universitas Negeri Yogyakarta"></span></a>
      <div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div>
    </div>
    <div class="platform-bar">
      <a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a>
      <button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button>
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('materi') }}">Materi</a>
        <a href="{{ route('jobsheet') }}">Jobsheet</a>
        <a href="{{ route('praktikum') }}">Praktikum</a>
        <a class="active" href="{{ route('panduan-praktikum') }}">Panduan Praktikum</a>
        <a href="{{ route('evaluasi') }}">Evaluasi</a>
        <a href="{{ route('laporan') }}">Unggah Laporan</a>
        <a href="{{ route('asisten-ai') }}">Asisten AI</a>
        <a href="{{ route('profil-dosen') }}">Profil Dosen</a>
        <a href="{{ route('tentang') }}">Tentang</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="page-hero">
      <p class="eyebrow">Panduan pelaksanaan</p>
      <h1>Panduan Praktikum</h1>
      <p>Gunakan panduan ini untuk mempersiapkan kegiatan, menjalankan praktikum dengan aman, dan menyusun hasil pengamatan secara sistematis.</p>
    </section>

    <section class="page-content">
      <ol class="page-list">
        <li><span>01 · Sebelum</span><div><strong>Siapkan diri dan peralatan</strong><p>Pelajari tujuan modul, siapkan alat dan bahan, lalu pastikan area kerja serta perangkat dalam kondisi aman.</p></div></li>
        <li><span>02 · Saat</span><div><strong>Ikuti langkah kerja</strong><p>Rakit dan ukur sesuai jobsheet. Catat hasil pengamatan serta perubahan yang terjadi pada rangkaian atau sinyal.</p></div></li>
        <li><span>03 · Sesudah</span><div><strong>Dokumentasikan hasil</strong><p>Rapikan peralatan, analisis data yang diperoleh, lalu susun laporan praktikum sesuai ketentuan dosen pengampu.</p></div></li>
      </ol>
    </section>
  </main>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
