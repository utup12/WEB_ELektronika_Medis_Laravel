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
@if(count($activities['tables'] ?? []) > 0)
<section class="jobsheet-observations" aria-labelledby="observation-heading">
<h2 id="observation-heading">Tabel Pengamatan Digital</h2>
<p>Format tabel berikut ditranskripsikan dari Jobsheet 2019. Nilai eksperimen sengaja kosong; isi setelah pengukuran yang disetujui dosen. Perhitungan otomatis adalah hasil model ideal, bukan pengukuran atau jaminan keselamatan rangkaian.</p>
@foreach($activities['tables'] as $observationTable)
<div class="jobsheet-observation-card" data-observation-table data-table-id="{{ $observationTable['id'] }}" data-table-kind="{{ $observationTable['kind'] }}" data-export-name="{{ $module['slug'] }}-tabel-{{ $observationTable['number'] }}">
<div class="jobsheet-observation-head">
<div>
<h3>Tabel {{ $observationTable['number'] }}. {{ $observationTable['title'] }}</h3>
<p>{{ $observationTable['note'] }}</p>
</div>
<a href="#halaman-{{ $observationTable['pdf_page'] }}">PDF halaman {{ $observationTable['pdf_page'] }}</a>
</div>
<div class="jobsheet-table-scroll">
<table class="jobsheet-observation-table">
<thead><tr>
@foreach($observationTable['columns'] as $column)
<th scope="col">{{ $column['label'] }}</th>
@endforeach
</tr></thead>
<tbody>
@foreach($observationTable['rows'] as $observationRow)
<tr>
@foreach($observationTable['columns'] as $column)
<td data-col="{{ $column['key'] }}" data-raw="{{ $column['type'] === 'fixed' ? ($observationRow[$column['key']] ?? '') : '' }}">
@if($column['type'] === 'fixed')
{{ str_replace('.', ',', (string) ($observationRow[$column['key']] ?? '')) }}
@elseif($column['type'] === 'input')
<label class="jobsheet-sr-only" for="obs-{{ $observationTable['id'] }}-{{ $loop->parent->iteration }}-{{ $column['key'] }}">{{ $column['label'] }} baris {{ $loop->parent->iteration }}</label>
<input id="obs-{{ $observationTable['id'] }}-{{ $loop->parent->iteration }}-{{ $column['key'] }}" type="number" step="any" data-input-col="{{ $column['key'] }}" inputmode="decimal" aria-label="{{ $column['label'] }} baris {{ $loop->parent->iteration }}" autocomplete="off" placeholder="—">
@else
<span data-result-col="{{ $column['key'] }}">—</span>
@endif
</td>
@endforeach
</tr>
@endforeach
</tbody>
</table>
</div>
@if($observationTable['kind'] === 'lpf')
<section class="jobsheet-frequency-chart" data-frequency-chart data-frequency-table="{{ $observationTable['id'] }}" aria-labelledby="grafik-{{ $observationTable['id'] }}">
<h4 id="grafik-{{ $observationTable['id'] }}">Grafik respons frekuensi · Tabel {{ $observationTable['number'] }}</h4>
<p>Kurva teoritis (bila tersedia dalam tabel asli) dibandingkan dengan penguatan hasil pengukuran. Grafik diperbarui ketika Vin dan Vout diisi. Skala frekuensi menggunakan logaritma.</p>
<div class="jobsheet-chart-legend">
<span><i class="jobsheet-legend-theory" aria-hidden="true"></i> Teoritis dari PDF</span>
<span><i class="jobsheet-legend-measured" aria-hidden="true"></i> Hasil eksperimen</span>
</div>
<div class="jobsheet-chart-scroll">
<svg viewBox="0 0 960 360" role="img" aria-label="Grafik respons frekuensi Low Pass Filter berdasarkan tabel pengamatan" width="960" height="360"></svg>
</div>
<p role="status" aria-live="polite" data-frequency-status>Belum ada pengukuran lengkap.</p>
<button type="button" data-save-chart>Unduh grafik SVG</button>
<p class="jobsheet-inline-note">Kurva teoritis diambil sebagaimana tercetak pada Tabel {{ $observationTable['number'] }}; tidak dianggap sebagai pengukuran. Jika tidak ada kolom teoritis pada tabel sumber, grafik tidak membuat kurva teoritis.</p>
</section>
@endif
<div class="jobsheet-observation-actions">
<button type="button" data-export-table>Unduh CSV hasil pengamatan</button>
<button type="button" data-reset-table>Hapus isian tabel</button>
</div>
<p class="jobsheet-observation-note" role="status" data-table-status>Isian hanya tersedia pada halaman ini dan tidak dikirim ke server. Unduh CSV sebelum menutup atau memuat ulang halaman.</p>
</div>
@endforeach
</section>
@endif
@if(count($activities['discussion'] ?? []) > 0)
<section class="jobsheet-discussion" aria-labelledby="discussion-heading" data-discussion data-discussion-title="{{ $module['title'] }}">
<h2 id="discussion-heading">Latihan Diskusi dari Jobsheet</h2>
<p>Pertanyaan berikut mengikuti dokumen sumber; jawaban diisi mandiri, tidak dinilai otomatis dan tidak disimpan ke server.</p>
@foreach($activities['discussion'] as $discussion)
<div class="jobsheet-discussion-item">
<label for="discussion-{{ $loop->iteration }}"><strong>{{ $discussion['number'] }}. {{ $discussion['text'] }}</strong></label>
<p><a href="#halaman-{{ $discussion['pdf_page'] }}">Rujukan halaman PDF {{ $discussion['pdf_page'] }}</a></p>
<textarea id="discussion-{{ $loop->iteration }}" data-discussion-answer rows="4" maxlength="2000" placeholder="Tuliskan penjelasan atau rancangan Anda..."></textarea>
</div>
@endforeach
<button type="button" data-export-discussion>Unduh jawaban diskusi (.txt)</button>
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
</section></main><script src="{{ asset('js/script.js') }}"></script>@if(count($activities['tables'] ?? []) > 0 || count($activities['discussion'] ?? []) > 0)<script defer src="{{ asset('js/jobsheet-observations.js') }}"></script>
@endif
@if($module['slug'] === 'low-pass-orde-pertama')
<script defer src="{{ asset('js/jobsheet-frequency-chart.js') }}"></script>
@endif
@if($edition['id'] === 'panduan-instrumentasi-elektronika-medis-2019' && $module['slug'] === 'penguat-ad620')<script defer src="{{ asset('js/ad620-calculator.js') }}"></script>
@endif
</body></html>
