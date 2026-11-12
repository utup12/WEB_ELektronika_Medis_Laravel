<!doctype html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>{{ $module['title'] }} | Jobsheet Elektronika Medis</title><link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link rel="stylesheet" href="{{ asset('css/identity.css') }}"><link rel="stylesheet" href="{{ asset('css/pages.css') }}"><link rel="stylesheet" href="{{ asset('css/jobsheet-learning.css') }}"></head>
<body><header class="site-header"><div class="identity-bar"><a class="uny-seal" href="{{ route('home') }}"><span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang UNY"></span></a><div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div></div><div class="platform-bar"><a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a><button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button><nav class="main-nav"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('materi') }}">Materi</a><a class="active" href="{{ route('jobsheet') }}">Jobsheet</a><a href="{{ route('praktikum') }}">Praktikum</a><a href="{{ route('evaluasi') }}">Evaluasi</a><a href="{{ route('asisten-ai') }}">Asisten AI</a></nav></div></header>
<main><section class="page-hero"><p class="eyebrow">{{ $edition['year'] }} · {{ $module['group'] }} · Jobsheet {{ $module['number'] ?? '—' }}</p><h1>{{ $module['title'] }}</h1><p>{{ $module['summary'] }}</p></section>
<section class="page-content"><p><a href="{{ route('jobsheet') }}">← Kembali ke katalog jobsheet</a></p>
<div class="ai-boundary"><strong>Referensi sumber sementara</strong>
<p>Judul panduan: {{ $edition['title'] }}. Penyusun: {{ $edition['author'] ?? 'Tidak dicantumkan' }}. Mulai halaman PDF: {{ $module['pdf_page'] ?? 'Belum tercatat' }}.</p>
<p>{{ $edition['status'] ?? 'Status belum diverifikasi.' }}</p>
<p>{{ $edition['source_note'] ?? 'Gunakan dokumen sumber untuk membaca teori, K3, alat dan bahan, langkah kerja, tabel pengamatan, serta pertanyaan diskusi secara lengkap.' }}</p>
<p>Ringkasan di website ini belum menggantikan prosedur lengkap pada dokumen asli. Ikuti supervisi dosen untuk penggunaan peralatan medis dan percobaan yang melibatkan tubuh manusia.</p>
</div>
@if($edition['id'] === 'panduan-instrumentasi-elektronika-medis-2019' && $module['slug'] === 'penguat-ad620')
<section data-ad620-calculator aria-labelledby="ad620-calculator-heading" style="margin:2rem 0;padding:1.5rem;border:1px solid #cad9e8;border-radius:16px;background:#f7fbff">
<h2 id="ad620-calculator-heading">Kalkulator Interaktif AD620</h2>
<p>Uji persamaan penguatan AD620 berdasarkan Jobsheet 2019 halaman PDF 16. Perhitungan berjalan langsung di browser, tanpa API.</p>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;align-items:end">
<label style="display:grid;gap:.5rem;font-weight:600">Jenis perhitungan
<select name="ad620-mode" style="padding:.75rem;border:1px solid #a9bdd0;border-radius:8px">
<option value="gain-to-resistor">Cari RG dari gain</option>
<option value="resistor-to-gain">Cari gain dari RG</option>
</select></label>
<label style="display:grid;gap:.5rem;font-weight:600"><span data-input-label>Penguatan G (kali)</span>
<input name="ad620-value" type="number" min="1.01" max="10000" step="any" value="100" inputmode="decimal" style="padding:.75rem;border:1px solid #a9bdd0;border-radius:8px"></label>
<label style="display:grid;gap:.5rem;font-weight:600">Satuan RG
<select name="ad620-unit" style="padding:.75rem;border:1px solid #a9bdd0;border-radius:8px" hidden>
<option value="ohm">Ω</option>
<option value="kohm" selected>kΩ</option>
</select></label>
</div>
<div aria-live="polite" style="margin-top:1rem;padding:1rem;background:#fff;border:1px solid #cad9e8;border-radius:12px">
<p style="margin:0;color:#345">Hasil perhitungan ideal</p>
<p data-calculator-output style="font-size:1.6rem;font-weight:750;margin:.3rem 0">498,99 Ω</p>
<p data-calculator-explanation style="margin:.5rem 0">RG = 49.400 Ω / (100 − 1).</p>
</div>
<p style="margin-top:1rem">Hasil teoritis tidak memperhitungkan toleransi komponen, saturasi keluaran, atau keselamatan pasien. Jangan menghubungkan rangkaian ke tubuh tanpa pemeriksaan dan supervisi dosen.</p>
<a href="#halaman-16">Lihat rujukan rumus di halaman PDF 16</a>
</section>
@endif
@if(count($equations ?? []) > 0)
<section aria-labelledby="verified-equations-heading" style="margin-top:2rem">
<h2 id="verified-equations-heading">Persamaan yang sudah diverifikasi</h2>
<p>Persamaan berikut ditranskripsikan dan diperiksa terhadap halaman PDF asli. Gunakan bersama dengan penjelasan dan batasan pada jobsheet.</p>
@foreach($equations as $equation)
<div style="padding:1rem 1.25rem;margin:1rem 0;border:1px solid #d9e3ef;border-radius:12px;background:#f8fbff">
<strong>{{ $equation['label'] }}</strong>
<p style="font-size:1.2rem;font-weight:700;overflow-wrap:anywhere">{{ $equation['expression'] }}</p>
<p>{{ $equation['note'] ?? '' }}</p>
<a href="#halaman-{{ $equation['pdf_page'] }}">Lihat teks halaman PDF {{ $equation['pdf_page'] }}</a>
</div>
@endforeach
</section>
@endif
@if(count($sections ?? []) > 0)
<section aria-labelledby="structured-heading" class="jobsheet-learning">
<h2 id="structured-heading">Materi Praktikum per Bagian</h2>
<p class="jobsheet-learning-intro">Disusun otomatis dari teks PDF sesuai urutan aslinya. Bagian yang belum dapat dikonversi, seperti tabel pengamatan, persamaan yang belum diverifikasi, dan gambar rangkaian, tetap harus dicek pada PDF sumber.</p>
<nav aria-label="Navigasi bagian jobsheet" class="jobsheet-section-nav">
<strong>Daftar bagian materi</strong>
<ul>
@foreach($sections as $section)
<li><a href="#bagian-{{ $loop->iteration }}">{{ $section['section'] }} <small>hlm. {{ $section['pdf_page'] }}</small></a></li>
@endforeach
</ul>
</nav>
@foreach($sections as $section)
<article id="bagian-{{ $loop->iteration }}" class="jobsheet-learning-card">
<div class="jobsheet-learning-heading">
<div>
<p class="jobsheet-section-overline">Bagian {{ $loop->iteration }} · {{ $module['title'] }}</p>
<h3>{{ $section['section'] }}</h3>
</div>
<a href="#halaman-{{ $section['pdf_page'] }}" class="jobsheet-page-link">Sumber PDF hlm. {{ $section['pdf_page'] }}</a>
</div>
<div class="jobsheet-learning-text">{{ $section['text'] }}</div>
@if(preg_match('/\\b(Tabel|Gambar|Rangkaian)\\s*\\d*\\b/iu', $section['text']) === 1)
<p class="jobsheet-inline-note">Bagian ini merujuk tabel atau gambar. Tata letak dan elemen visual belum diverifikasi; lihat dokumen asli sebelum melakukan praktikum.</p>
@endif
</article>
@endforeach
</section>
@endif
@if(count($pages) > 0)
<section aria-labelledby="source-text-heading" style="margin-top:2rem">
<h2 id="source-text-heading">Arsip Teks PDF per Halaman</h2>
<p>Arsip berikut menampilkan transkripsi lengkap lapisan teks sebagai pembanding materi terstruktur di atas.</p>
<p>Materi berikut merupakan hasil ekstraksi lapisan teks PDF berdasarkan halaman sumber. Untuk memastikan bentuk rangkaian, rumus, diagram, dan tabel, tetap gunakan PDF asli; tata letaknya belum sepenuhnya dapat dipertahankan.</p>
@foreach($pages as $page)
<details id="halaman-{{ $page['pdf_page'] }}" style="margin:1rem 0;border:1px solid #d9e3ef;border-radius:12px;padding:1rem;background:#fff">
<summary style="cursor:pointer;font-weight:700">Halaman PDF {{ $page['pdf_page'] }}</summary>
<div style="white-space:pre-wrap;overflow-wrap:anywhere;line-height:1.75;margin-top:1rem;font-family:inherit">{{ $page['text'] }}</div>
</details>
@endforeach
</section>
@else
<p>Konten lengkap untuk modul ini belum tersedia dalam folder sumber.</p>
@endif
</section></main><script src="{{ asset('js/script.js') }}"></script>@if($edition['id'] === 'panduan-instrumentasi-elektronika-medis-2019' && $module['slug'] === 'penguat-ad620')<script defer src="{{ asset('js/ad620-calculator.js') }}"></script>@endif</body></html>
