<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Platform pembelajaran untuk mata kuliah Praktik Elektronika Medis, Pendidikan Teknik Elektronika."
    >

    <title>Praktik Elektronika Medis | PTE UNY</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Favicon -->
    <link
        rel="icon"
        type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%230b3b62'/%3E%3Cpath d='M10 35h10l5-15 8 29 7-18h14' fill='none' stroke='%2349d8c5' stroke-width='5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"
    >

    <!-- CSS WEBSITE LAMA -->
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/identity.css">
    <link rel="stylesheet" href="/css/compact-features.css">
    <link rel="stylesheet" href="/css/report-upload.css">
    <link rel="stylesheet" href="/css/dark-mode-fix.css">
    <link rel="stylesheet" href="/css/visual-enhancements.css">
    <link rel="stylesheet" href="/css/pages.css">
</head>


<body>

    <!-- ==========================================
         HEADER
    =========================================== -->

    <header class="site-header">

        <!-- IDENTITAS UNY -->
        <div class="identity-bar">

            <a
                class="uny-seal"
                href="{{ route('home', [], false) }}"
                aria-label="Universitas Negeri Yogyakarta"
            >
                <span>
                    <img
                        src="/assets/logo-uny.png"
                        alt="Lambang Universitas Negeri Yogyakarta"
                    >
                </span>
            </a>

            <div class="institution-name">
                <strong>Universitas Negeri Yogyakarta</strong>

                <span>
                    Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika
                </span>
            </div>

        </div>


        <!-- NAVIGATION BAR -->
        <div class="platform-bar">

            <details class="nav-dropdown">

                <summary>

                    <span class="menu-icon" aria-hidden="true">
                        <i></i>
                        <i></i>
                        <i></i>
                    </span>

                    <span>Menu</span>

                </summary>


                <nav
                    class="main-nav"
                    aria-label="Navigasi utama"
                >

                    <a
                        class="active"
                        href="{{ route('home', [], false) }}"
                    >
                        Beranda
                    </a>

                    <a href="{{ route('materi', [], false) }}">
                        Materi
                    </a>

                    <a href="{{ route('praktikum', [], false) }}">
                        Praktikum
                    </a>

                    <a href="{{ route('evaluasi', [], false) }}">
                        Evaluasi
                    </a>

                    <a href="{{ route('laporan', [], false) }}">
                        Unggah Laporan
                    </a>

                    <a href="{{ route('asisten-ai', [], false) }}">
                        Asisten AI
                    </a>

                    <!-- route profil dosen akan kita buat setelah ini -->
                    <a href="{{ route('profil-dosen', [], false) }}">
                        Profil Dosen
                    </a>

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


            <div class="header-tools">

                <a
                    class="course-brand"
                    href="#beranda"
                >
                    Praktik Elektronika Medis
                </a>

                @guest
                    <a class="header-login" href="{{ route('masuk', [], false) }}">Masuk</a>
                @else
                    @if(auth()->user()->isLecturer())
                        <a class="header-login" href="{{ route('dosen.dashboard', [], false) }}">Dashboard Dosen</a>
                    @else
                        <a class="header-login" href="{{ route('student.progress', [], false) }}">Progres Saya</a>
                    @endif
                @endguest


                <button
                    class="theme-control"
                    type="button"
                    aria-label="Ubah mode warna"
                    title="Ubah mode warna"
                >
                    ◐
                </button>

            </div>

        </div>

    </header>


    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->

    <main>


        <!-- ==========================================
             HERO
        =========================================== -->

        <section
            class="hero"
            id="beranda"
        >

            <div class="hero-copy">

                <p class="eyebrow">
                    <span></span>
                    Pendidikan Teknik Elektronika
                </p>


                <h1>
                    Memahami
                    <em>instrumentasi medis</em>
                    melalui praktik elektronika.
                </h1>


                <p class="hero-text">

                    Ruang belajar digital untuk Praktik Elektronika Medis.

                    Mahasiswa mempelajari prinsip kerja sensor,
                    pengkondisian dan akuisisi sinyal,
                    serta pengolahan data pengukuran secara bertahap
                    dan bertanggung jawab.

                </p>


                <div class="hero-actions">

                    <a
                        class="button primary"
                        href="{{ route('praktikum', [], false) }}"
                    >
                        Jelajahi Praktikum
                        <span>→</span>
                    </a>


                    <a
                        class="button text-button"
                        href="#training-kit"
                    >
                        Lihat trainer kit
                        <span>↓</span>
                    </a>

                </div>


                <div class="course-meta">

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

        </section>


        <!-- ==========================================
             TRAINER KIT
        =========================================== -->

        <section
            class="training-showcase section"
            id="training-kit"
        >

            <figure class="training-photo">

                <img
                    src="/assets/training-kit-hd.png"
                    alt="Ilustrasi trainer kit elektronika medis dengan monitor dan beberapa sensor"
                >

                <figcaption>
                    Ilustrasi sementara — akan diganti dengan foto training
                    kit hasil pengembangan.
                </figcaption>

            </figure>


            <div class="training-copy">

                <p class="eyebrow">
                    Media praktikum
                </p>


                <h2>
                    Trainer kit elektronika medis terintegrasi.
                </h2>


                <p>

                    Perangkat ini dirancang sebagai media pembelajaran
                    untuk menghubungkan sensor, rangkaian pengondisi sinyal,
                    dan sistem akuisisi data dalam satu kegiatan praktikum.

                </p>


                <p class="training-notice">

                    <strong>
                        Ingin melihat keluaran sinyal?
                    </strong>

                    Buka menu Praktikum, pilih modul, lalu hubungkan
                    perangkat yang tersedia.

                    Untuk sementara, pengujian koneksi menggunakan smartwatch.

                </p>


                <a
                    class="button primary"
                    href="{{ route('praktikum', [], false) }}"
                >
                    Buka menu Praktikum
                    <span>→</span>
                </a>

            </div>

        </section>


        <!-- ==========================================
             TENTANG PEMBELAJARAN
        =========================================== -->

        <section
            class="intro section"
            id="materi"
        >

            <div>

                <p class="eyebrow">
                    Tentang pembelajaran
                </p>


                <h2>
                    Dari konsep rangkaian hingga interpretasi teknis sinyal.
                </h2>

            </div>


            <p>

                Setiap sesi dirancang untuk menghubungkan teori
                instrumentasi dengan pengalaman praktik:

                mahasiswa merakit, mengukur, mengamati,
                lalu mendokumentasikan hasilnya.

                Platform ini mendukung proses tersebut dalam satu tempat.

            </p>

        </section>


        <!-- ==========================================
             CAPAIAN PEMBELAJARAN
        =========================================== -->

        <section
            class="outcomes section"
            aria-labelledby="outcomes-title"
        >

            <div class="section-heading">

                <p class="eyebrow">
                    Capaian Pembelajaran Mata Kuliah
                </p>


                <h2 id="outcomes-title">
                    Capaian Pembelajaran Praktik Elektronika Medis
                </h2>


                <p class="outcomes-intro">
                    Kompetensi yang dituju mahasiswa selama mengikuti praktikum.
                </p>

            </div>


            <div class="outcome-grid">

                <article>

                    <span class="number">
                        CPL-1
                    </span>


                    <h3>
                        Etika dan keselamatan profesional
                    </h3>


                    <p>

                        Menunjukkan etika profesional,
                        tanggung jawab sosial,
                        serta norma akademik dalam pelaksanaan
                        praktik instrumentasi medik.

                    </p>

                </article>


                <article>

                    <span class="number">
                        CPL-3
                    </span>


                    <h3>
                        Sistem instrumentasi medik
                    </h3>


                    <p>

                        Mampu merancang, mengoperasikan,
                        dan mengelola sistem elektronika
                        pada konteks instrumentasi medik dasar.

                    </p>

                </article>


                <article>

                    <span class="number">
                        CPL-4
                    </span>


                    <h3>
                        Analisis dan pemecahan masalah
                    </h3>


                    <p>

                        Menganalisis hasil pengukuran,
                        gangguan sinyal, dan kinerja rangkaian
                        untuk merumuskan solusi teknis yang tepat.

                    </p>

                </article>


                <article>

                    <span class="number">
                        CPL-7 · CPL-8
                    </span>


                    <h3>
                        Kinerja dan komunikasi ilmiah
                    </h3>


                    <p>

                        Menunjukkan kinerja mandiri maupun kolaboratif
                        serta menyusun laporan praktikum secara sistematis
                        dan bertanggung jawab.

                    </p>

                </article>

            </div>

        </section>


        <!-- ==========================================
             MODUL PRAKTIKUM
        =========================================== -->

        <section
            class="modules section"
            id="praktikum"
        >

            <div class="section-heading split">

                <div>

                    <p class="eyebrow">
                        Peta praktikum semester
                    </p>


                    <h2>
                        Empat belas jobsheet, satu alur belajar.
                    </h2>

                </div>


                <a
                    href="{{ route('praktikum', [], false) }}#jobsheet"
                    class="inline-link"
                >
                    Lihat semua jobsheet
                    <span>→</span>
                </a>

            </div>


            @php($homeEdition = $editions[0] ?? null)
            <div class="module-grid">
                @if($homeEdition && !empty($homeEdition['modules']))
                    @foreach($homeEdition['modules'] as $module)
                        <a
                            class="module-card {{ $loop->first ? 'featured' : ($loop->last ? 'accent' : '') }}"
                            href="{{ route('jobsheet.module', [$homeEdition['id'], $module['slug']], false) }}"
                            style="text-decoration:none;color:inherit"
                        >
                            <span class="module-label">
                                Jobsheet {{ str_pad((string) ($module['number'] ?? $loop->iteration), 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <h3>
                                {{ $module['title'] }}
                            </h3>

                            <p>
                                {{ $module['summary'] ?? '' }}
                            </p>

                            <span class="card-arrow">
                                ↗
                            </span>
                        </a>
                    @endforeach
                @endif
            </div>

        </section>


        <!-- ==========================================
             ALUR BELAJAR
        =========================================== -->

        <section
            class="learning-flow section"
            id="jobsheet"
        >

            <div class="flow-copy">

                <p class="eyebrow">
                    Alur belajar
                </p>


                <h2>
                    Siapkan, praktikkan, pahami, refleksikan.
                </h2>


                <p>

                    Struktur ini akan menjadi kerangka setiap jobsheet
                    agar mahasiswa tahu apa yang perlu dilakukan
                    sebelum, selama, dan setelah praktikum.

                </p>


                <a
                    class="button outline"
                    href="{{ route('evaluasi', [], false) }}"
                >
                    Lihat format evaluasi
                    <span>→</span>
                </a>

            </div>


            <ol class="flow-list">

                <li>

                    <span>
                        01
                    </span>


                    <div>

                        <h3>
                            Pelajari materi
                        </h3>


                        <p>
                            Konsep, diagram rangkaian,
                            dan tujuan praktik.
                        </p>

                    </div>

                </li>


                <li>

                    <span>
                        02
                    </span>


                    <div>

                        <h3>
                            Ikuti jobsheet
                        </h3>


                        <p>
                            Persiapan alat,
                            langkah kerja, dan titik ukur.
                        </p>

                    </div>

                </li>


                <li>

                    <span>
                        03
                    </span>


                    <div>

                        <h3>
                            Amati hasil praktik
                        </h3>


                        <p>
                            Catat data pengukuran
                            dan hasil observasi pada lembar kerja.
                        </p>

                    </div>

                </li>


                <li>

                    <span>
                        04
                    </span>


                    <div>

                        <h3>
                            Evaluasi hasil
                        </h3>


                        <p>
                            Unggah laporan dan selesaikan
                            refleksi singkat.
                        </p>

                    </div>

                </li>

            </ol>

        </section>


        <!-- ==========================================
             FITUR PLATFORM
        =========================================== -->

        <section
            class="platform section"
            id="evaluasi"
        >

            <div class="section-heading">

                <p class="eyebrow">
                    Ruang belajar terintegrasi
                </p>


                <h2>
                    Fondasi untuk pelaksanaan praktikum yang terarah.
                </h2>

            </div>


            <div class="feature-grid feature-grid-compact">

                <article>

                    <span class="feature-icon">
                        ▤
                    </span>


                    <h3>
                        Materi & Jobsheet
                    </h3>


                    <p>
                        Bahan ajar, panduan kerja,
                        dan lembar pencatatan yang tertata per modul.
                    </p>

                </article>


                <article>

                    <span class="feature-icon">
                        ✓
                    </span>


                    <h3>
                        Evaluasi
                    </h3>


                    <p>
                        Kuis, refleksi, dan penilaian laporan
                        praktikum dalam satu alur pembelajaran.
                    </p>

                </article>

            </div>

        </section>


        <!-- ==========================================
             CTA
        =========================================== -->

        <section class="cta section">

            <p class="eyebrow">
                Mulai dari modul pertama
            </p>


            <h2>
                Praktikum yang terarah dimulai
                dari persiapan yang baik.
            </h2>


            <a
                class="button primary"
                href="#praktikum"
            >
                Pilih Modul Praktikum
                <span>→</span>
            </a>

        </section>

    </main>


    <!-- ==========================================
         FOOTER
    =========================================== -->

    <footer id="tentang">

        <div class="footer-brand">

            <p class="footer-course">
                Praktik Elektronika Medis
            </p>


            <p>
                Program Studi Pendidikan Teknik Elektronika
                <br>
                Fakultas Teknik · Universitas Negeri Yogyakarta
            </p>

        </div>


        <div>

            <h3>
                Alamat Kampus
            </h3>


            <p>
                Kampus Karangmalang
                <br>
                Yogyakarta 55281
            </p>


            <a
                href="https://ft.uny.ac.id"
                target="_blank"
                rel="noopener noreferrer"
            >
                ft.uny.ac.id ↗
            </a>

        </div>


        <div>

            <h3>
                Pengembang
            </h3>


            <p>
                I Putu Adhi Baswara, S.Pd.
            </p>

            <p>
                NIM 26051640021
            </p>


            <a
                href="https://wa.me/6285800302847"
                target="_blank"
                rel="noopener noreferrer"
            >
                WhatsApp · 0858 0030 2847
            </a>



        </div>


        <p class="footer-note">
            © 2026 Fakultas Teknik UNY
            <br>
            Dibuat untuk pembelajaran, bukan diagnosis medis.
        </p>

    </footer>


    <!-- ==========================================
         JAVASCRIPT WEBSITE
    =========================================== -->

    <script src="/js/navigation.js"></script>

    <script src="/js/script.js"></script>
    <script src="/js/motion.js"></script>

</body>
</html>
