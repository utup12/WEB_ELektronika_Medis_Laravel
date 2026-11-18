<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform pembelajaran untuk mata kuliah Praktik Elektronika Medis, Pendidikan Teknik Elektronika.">
    <title>Praktik Elektronika Medis | PTE UNY</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:wght@500;600&family=IBM+Plex+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%230b3b62'/%3E%3Cpath d='M10 35h10l5-15 8 29 7-18h14' fill='none' stroke='%2349d8c5' stroke-width='5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">

    <link rel="stylesheet" href="/css/identity.css">
    <link rel="stylesheet" href="/css/hallmark-cobalt.css">
<link rel="stylesheet" href="/css/a11y.css">
</head>
<body><a class="skip-link" href="#main-content">Lewati ke konten utama</a>

    <header class="site-header">
        <div class="identity-bar">
            <a class="uny-seal" href="{{ route('home', [], false) }}" aria-label="Universitas Negeri Yogyakarta">
                <span>
                    <img src="/assets/logo-uny.png" alt="Lambang Universitas Negeri Yogyakarta">
                </span>
            </a>
            <div class="institution-name">
                <strong>Universitas Negeri Yogyakarta</strong>
                <span>Fakultas Teknik, Program Studi Pendidikan Teknik Elektronika</span>
            </div>
        </div>

        <div class="platform-bar">
            <details class="nav-dropdown">
                <summary>
                    <span class="menu-icon" aria-hidden="true"><i></i><i></i><i></i></span>
                    <span>Menu</span>
                </summary>

                <nav class="main-nav" aria-label="Navigasi utama">
                    <a class="active" href="{{ route('home', [], false) }}">Beranda</a>
                    <a href="{{ route('materi', [], false) }}">Materi</a>
                    <a href="{{ route('praktikum', [], false) }}">Praktikum</a>
                    <a href="{{ route('monitor-trainer', [], false) }}">Monitor Heart Rate (BLE)</a>
                    <a href="{{ route('evaluasi', [], false) }}">Evaluasi</a>
                    <a href="{{ route('laporan', [], false) }}">Unggah Laporan</a>
                    <a href="{{ route('asisten-ai', [], false) }}">Asisten AI</a>
                    <a href="{{ route('profil-dosen', [], false) }}">Profil Dosen</a>
                    @auth
                        @if(auth()->user()->isLecturer())
                            <a href="{{ route('dosen.dashboard', [], false) }}">Dashboard Dosen</a>
                        @else
                            <a href="{{ route('student.progress', [], false) }}">Progres Saya</a>
                            <a href="{{ route('student.notes', [], false) }}">Catatan Mahasiswa</a>
                        @endif
                    @endauth
                </nav>
            </details>

            @auth
                <form class="logout-form" method="POST" action="{{ route('keluar') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            @endauth

            <div class="header-tools">
                <a class="course-brand" href="#beranda">Praktik Elektronika Medis</a>

                @guest
                    <a class="header-login" href="{{ route('masuk', [], false) }}">Masuk</a>
                @else
                    @if(auth()->user()->isLecturer())
                        <a class="header-login" href="{{ route('dosen.dashboard', [], false) }}">Dashboard Dosen</a>
                    @else
                        <a class="header-login" href="{{ route('student.progress', [], false) }}">Progres Saya</a>
                    @endif
                @endguest

                <button class="theme-control" type="button" aria-label="Ubah mode warna" title="Ubah mode warna">◐</button>
            </div>
        </div>
    </header>

    <main id="main-content" tabindex="-1">
        <!-- HERO (Stage Posture) -->
        <section class="hm-hero" id="beranda">
            <div class="hm-shell hm-hero-grid">
                <div class="hm-hero-copy">
                    <h1>Memahami instrumentasi medis melalui praktik elektronika.</h1>
                    <p class="hm-hero-lede">
                        Ruang belajar digital untuk mempelajari prinsip kerja sensor, pengkondisian sinyal, dan akuisisi data pengukuran secara bertahap.
                    </p>

                    <div class="hm-hero-actions">
                        <a class="key key--primary" href="{{ route('praktikum', [], false) }}">
                            <span>Jelajahi Praktikum</span>
                            <span aria-hidden="true">→</span>
                        </a>
                        <a class="key" href="#training-kit">
                            <span>Lihat trainer kit</span>
                            <span aria-hidden="true">↓</span>
                        </a>
                    </div>

                    <div class="hm-stat-strip">
                        <div>
                            <strong>16</strong>
                            <span>Pertemuan</span>
                        </div>
                        <div>
                            <strong>14</strong>
                            <span>Topik jobsheet</span>
                        </div>
                        <div>
                            <strong>2 SKS</strong>
                            <span>Praktik terstruktur</span>
                        </div>
                    </div>
                </div>

                <aside class="hm-hero-stage cut" aria-label="Ringkasan perangkat praktikum">
                    <figure>
                        <img src="/assets/training-kit-hd.png" alt="Ilustrasi trainer kit elektronika medis dengan monitor dan sensor">
                    </figure>
                    <div class="hm-stage-meta">
                        <div>
                            <strong>AD620</strong>
                            <span>Penguat instrumentasi</span>
                        </div>
                        <div>
                            <strong>ECG / EMG</strong>
                            <span>Akuisisi biopotensial</span>
                        </div>
                        <div>
                            <strong>PPG</strong>
                            <span>Simulasi detak jantung</span>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <!-- TRAINER KIT (Graphite Band) -->
        <section class="hm-graphite-band" id="training-kit">
            <div class="hm-shell hm-trainer-grid">
                <figure class="hm-trainer-figure cut">
                    <img src="/assets/training-kit-hd.png" alt="Ilustrasi trainer kit elektronika medis dengan monitor dan beberapa sensor">
                    <figcaption>Ilustrasi sementara — akan diganti dengan foto training kit hasil pengembangan.</figcaption>
                </figure>

                <div>
                    <h2>Trainer kit elektronika medis terintegrasi.</h2>
                    <p>
                        Perangkat ini dirancang sebagai media pembelajaran untuk menghubungkan sensor, rangkaian pengondisi sinyal, dan sistem akuisisi data dalam satu kegiatan praktikum.
                    </p>

                    <div class="hm-notice-box">
                        <strong>Ingin melihat keluaran sinyal?</strong>
                        Buka menu Praktikum, pilih modul, lalu hubungkan perangkat yang tersedia. Untuk sementara, pengujian koneksi menggunakan smartwatch via Bluetooth Low Energy (BLE).
                    </div>

                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px">
                        <a class="key key--primary" href="{{ route('monitor-trainer', [], false) }}">
                            <span>Buka Monitor Heart Rate (BLE)</span>
                            <span aria-hidden="true">→</span>
                        </a>
                        <a class="key" href="{{ route('pilot.heart-rate', [], false) }}">
                            <span>Alur Smartwatch &amp; PPG</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CAPAIAN PEMBELAJARAN -->
        <section class="hm-section" id="materi" aria-labelledby="outcomes-title">
            <div class="hm-shell">
                <div class="hm-section-head">
                    <div>
                        <h2 id="outcomes-title">Capaian Pembelajaran Praktik Elektronika Medis</h2>
                        <p>Dari konsep rangkaian hingga interpretasi teknis sinyal selama mengikuti praktikum.</p>
                    </div>
                </div>

                <div class="hm-outcomes-grid">
                    <article class="hm-outcome-item">
                        <span class="hm-outcome-code">CPL-1</span>
                        <h3>Etika dan keselamatan profesional</h3>
                        <p>Menunjukkan etika profesional, tanggung jawab sosial, serta norma akademik dalam pelaksanaan praktik instrumentasi medik.</p>
                    </article>
                    <article class="hm-outcome-item">
                        <span class="hm-outcome-code">CPL-3</span>
                        <h3>Sistem instrumentasi medik</h3>
                        <p>Mampu merancang, mengoperasikan, dan mengelola sistem elektronika pada konteks instrumentasi medik dasar.</p>
                    </article>
                    <article class="hm-outcome-item">
                        <span class="hm-outcome-code">CPL-4</span>
                        <h3>Analisis dan pemecahan masalah</h3>
                        <p>Menganalisis hasil pengukuran, gangguan sinyal, dan kinerja rangkaian untuk merumuskan solusi teknis yang tepat.</p>
                    </article>
                    <article class="hm-outcome-item">
                        <span class="hm-outcome-code">CPL-7 / CPL-8</span>
                        <h3>Kinerja dan komunikasi ilmiah</h3>
                        <p>Menunjukkan kinerja mandiri maupun kolaboratif serta menyusun laporan praktikum secara sistematis dan bertanggung jawab.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- 14 JOBSHEET -->
        <section class="hm-section" id="praktikum">
            <div class="hm-shell">
                <div class="hm-section-head">
                    <div>
                        <h2>Empat belas jobsheet, satu alur belajar.</h2>
                        <p>Peta praktikum semester dari penguat instrumentasi hingga akuisisi sinyal biomedis.</p>
                    </div>
                    <a class="key" href="{{ route('praktikum', [], false) }}#jobsheet">
                        <span>Lihat semua jobsheet</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                @php($homeEdition = $editions[0] ?? null)
                <div class="hm-jobsheet-grid">
                    @if($homeEdition && !empty($homeEdition['modules']))
                        @foreach($homeEdition['modules'] as $module)
                            <a class="hm-jobsheet-card cut {{ $loop->first ? 'is-lead' : '' }}" href="{{ route('jobsheet.module', [$homeEdition['id'], $module['slug']], false) }}">
                                <div>
                                    <span class="hm-jobsheet-num">Jobsheet {{ str_pad((string) ($module['number'] ?? $loop->iteration), 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3>{{ $module['title'] }}</h3>
                                </div>
                                <p>{{ $module['summary'] ?? '' }}</p>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <!-- ALUR BELAJAR -->
        <section class="hm-section" id="jobsheet">
            <div class="hm-shell hm-flow-grid">
                <div>
                    <h2>Siapkan, praktikkan, pahami, refleksikan.</h2>
                    <p style="color:var(--color-muted);margin:14px 0 24px">
                        Struktur ini menjadi kerangka setiap jobsheet agar mahasiswa mengetahui langkah yang perlu dilakukan sebelum, selama, dan setelah praktikum.
                    </p>
                    <a class="key" href="{{ route('evaluasi', [], false) }}">
                        <span>Lihat format evaluasi</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <ol class="hm-flow-list">
                    <li>
                        <span>01</span>
                        <div>
                            <h3>Pelajari materi</h3>
                            <p>Konsep, diagram rangkaian, dan tujuan praktik.</p>
                        </div>
                    </li>
                    <li>
                        <span>02</span>
                        <div>
                            <h3>Siapkan rangkaian</h3>
                            <p>Pemeriksaan konektivitas, catu daya, dan prosedur keselamatan.</p>
                        </div>
                    </li>
                    <li>
                        <span>03</span>
                        <div>
                            <h3>Praktik dan ukur</h3>
                            <p>Pengamatan sinyal keluaran dan pencatatan data terstruktur.</p>
                        </div>
                    </li>
                    <li>
                        <span>04</span>
                        <div>
                            <h3>Evaluasi</h3>
                            <p>Kuis, refleksi, dan penilaian laporan praktikum dalam satu alur pembelajaran.</p>
                        </div>
                    </li>
                </ol>
            </div>
        </section>

        <!-- CTA -->
        <section class="hm-section">
            <div class="hm-shell">
                <div class="hm-cta-band cut">
                    <h2>Praktikum yang terarah dimulai dari persiapan yang baik.</h2>
                    <a class="key key--primary" href="#praktikum">
                        <span>Pilih Modul Praktikum</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="hm-footer" id="tentang">
        <div class="hm-shell">
            <div class="hm-footer-grid">
                <div>
                    <h3>Praktik Elektronika Medis</h3>
                    <p>Program Studi Pendidikan Teknik Elektronika<br>Fakultas Teknik, Universitas Negeri Yogyakarta</p>
                </div>
                <div>
                    <h3>Alamat Kampus</h3>
                    <p>Kampus Karangmalang<br>Yogyakarta 55281</p>
                    <a href="https://ft.uny.ac.id" target="_blank" rel="noopener noreferrer">ft.uny.ac.id</a>
                </div>
                <div>
                    <h3>Pengembang</h3>
                    <p>I Putu Adhi Baswara, S.Pd.<br>NIM 26051640021</p>
                    <a href="https://wa.me/6285800302847" target="_blank" rel="noopener noreferrer">WhatsApp 0858 0030 2847</a>
                </div>
            </div>
            <p class="hm-footer-note">© 2026 Fakultas Teknik UNY — Dibuat untuk pembelajaran, bukan diagnosis medis.</p>
        </div>
    </footer>

    <script src="/js/navigation.js"></script>
    <script src="/js/script.js"></script>
</body>
</html>
