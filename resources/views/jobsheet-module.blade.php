<!doctype html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>{{ $module['title'] }} | Jobsheet Elektronika Medis</title><link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link rel="stylesheet" href="{{ asset('css/identity.css') }}"><link rel="stylesheet" href="{{ asset('css/pages.css') }}"></head>
<body><header class="site-header"><div class="identity-bar"><a class="uny-seal" href="{{ route('home') }}"><span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang UNY"></span></a><div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span></div></div><div class="platform-bar"><a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a><button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button><nav class="main-nav"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('materi') }}">Materi</a><a class="active" href="{{ route('jobsheet') }}">Jobsheet</a><a href="{{ route('praktikum') }}">Praktikum</a><a href="{{ route('evaluasi') }}">Evaluasi</a><a href="{{ route('asisten-ai') }}">Asisten AI</a></nav></div></header>
<main><section class="page-hero"><p class="eyebrow">{{ $edition['year'] }} · {{ $module['group'] }} · Jobsheet {{ $module['number'] ?? '—' }}</p><h1>{{ $module['title'] }}</h1><p>{{ $module['summary'] }}</p></section>
<section class="page-content"><p><a href="{{ route('jobsheet') }}">← Kembali ke katalog jobsheet</a></p>
<div class="ai-boundary"><strong>Referensi sumber sementara</strong>
<p>Judul panduan: {{ $edition['title'] }}. Penyusun: {{ $edition['author'] ?? 'Tidak dicantumkan' }}. Mulai halaman PDF: {{ $module['pdf_page'] ?? 'Belum tercatat' }}.</p>
<p>{{ $edition['status'] ?? 'Status belum diverifikasi.' }}</p>
<p>{{ $edition['source_note'] ?? 'Gunakan dokumen sumber untuk membaca teori, K3, alat dan bahan, langkah kerja, tabel pengamatan, serta pertanyaan diskusi secara lengkap.' }}</p>
<p>Ringkasan di website ini belum menggantikan prosedur lengkap pada dokumen asli. Ikuti supervisi dosen untuk penggunaan peralatan medis dan percobaan yang melibatkan tubuh manusia.</p>
</div>
@if(count($pages) > 0)
<section aria-labelledby="source-text-heading" style="margin-top:2rem">
<h2 id="source-text-heading">Isi Jobsheet dari Dokumen 2019</h2>
<p>Materi berikut merupakan hasil ekstraksi lapisan teks PDF berdasarkan halaman sumber. Untuk memastikan bentuk rangkaian, rumus, diagram, dan tabel, tetap gunakan PDF asli; tata letaknya belum sepenuhnya dapat dipertahankan.</p>
@foreach($pages as $page)
<details id="halaman-{{ $page['pdf_page'] }}" style="margin:1rem 0;border:1px solid #d9e3ef;border-radius:12px;padding:1rem;background:#fff" {{ $loop->first ? 'open' : '' }}>
<summary style="cursor:pointer;font-weight:700">Halaman PDF {{ $page['pdf_page'] }}</summary>
<div style="white-space:pre-wrap;overflow-wrap:anywhere;line-height:1.75;margin-top:1rem;font-family:inherit">{{ $page['text'] }}</div>
</details>
@endforeach
</section>
@else
<p>Konten lengkap untuk modul ini belum tersedia dalam folder sumber.</p>
@endif
</section></main><script src="{{ asset('js/script.js') }}"></script></body></html>
