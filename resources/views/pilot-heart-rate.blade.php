<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Candidate Pilot Heart Rate / PPG | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="identity-bar">
            <a class="uny-seal" href="{{ route('home') }}">
                <span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang Universitas Negeri Yogyakarta"></span>
            </a>
            <div class="institution-name">
                <strong>Universitas Negeri Yogyakarta</strong>
                <span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span>
            </div>
        </div>
        <div class="platform-bar">
            <a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a>
            <button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('materi') }}">Materi</a>
                <a href="{{ route('jobsheet') }}">Jobsheet</a>
                <a class="active" href="{{ route('praktikum') }}">Praktikum</a>
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
            <p class="eyebrow">Candidate pilot · belum modul resmi</p>
            <h1>Heart Rate / PPG</h1>
            <p>Halaman ini adalah kerangka teknis untuk menelusuri satu siklus pembelajaran end-to-end. Pemilihan modul, isi akademik, prosedur praktikum, kriteria interpretasi, dan validasi hardware tetap harus dikonfirmasi mahasiswa bersama dosen pengampu.</p>
        </section>

        <section class="page-content">
            <div class="ai-boundary">
                <strong>Status kandidat</strong>
                Heart Rate/PPG dipakai sementara karena Monitor Trainer sudah tersedia. Halaman ini bukan bukti bahwa Heart Rate/PPG telah ditetapkan sebagai modul penelitian resmi atau bahwa perangkat BLE fisik telah tervalidasi.
            </div>

            <div class="content-grid" aria-label="Alur candidate pilot">
                <article class="content-card">
                    <span>01</span>
                    <h2>Materi</h2>
                    <p>Placeholder untuk materi resmi, konsep sensor, pengkondisian sinyal, dan konteks pengukuran.</p>
                    <a class="button text-button" href="{{ route('materi') }}">Buka Materi <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>02</span>
                    <h2>Pre-lab</h2>
                    <p>Gunakan evaluasi kesiapan sebagai kerangka awal. Soal final harus disesuaikan dengan modul resmi.</p>
                    <a class="button text-button" href="{{ route('evaluasi') }}">Buka Pre-lab <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>03</span>
                    <h2>Jobsheet</h2>
                    <p>Placeholder untuk tujuan, alat-bahan, keselamatan, langkah kerja, tabel data, dan kriteria penilaian.</p>
                    <a class="button text-button" href="{{ route('jobsheet') }}">Buka Jobsheet <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>04</span>
                    <h2>Praktikum</h2>
                    <p>Tahap pelaksanaan yang menghubungkan prosedur, trainer, dan hasil pengukuran.</p>
                    <a class="button text-button" href="{{ route('praktikum') }}">Buka Praktikum <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>05</span>
                    <h2>Monitor Trainer</h2>
                    <p>Mode simulasi tersedia. Uji BLE fisik dan bukti kestabilan koneksi tetap menjadi pekerjaan mahasiswa.</p>
                    <a class="button text-button" href="{{ route('monitor-trainer') }}">Buka Monitor <span>→</span></a>
                </article>

                <article class="content-card" id="interpretasi">
                    <span>06</span>
                    <h2>Interpretasi</h2>
                    <p>Kerangka analisis hasil. Batas normal, aturan interpretasi, dan indikator keberhasilan belum ditetapkan pada tahap ini.</p>
                </article>

                <article class="content-card" id="refleksi">
                    <span>07</span>
                    <h2>Refleksi</h2>
                    <p>Kerangka refleksi untuk membandingkan tujuan, proses, hasil, kendala, dan perbaikan praktikum.</p>
                </article>

                <article class="content-card">
                    <span>08</span>
                    <h2>Laporan</h2>
                    <p>Tahap dokumentasi akhir yang memuat identitas, data, analisis teknis, dan kesimpulan.</p>
                    <a class="button text-button" href="{{ route('laporan') }}">Buka Laporan <span>→</span></a>
                </article>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
