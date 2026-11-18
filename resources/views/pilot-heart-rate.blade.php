<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Candidate Pilot Heart Rate / PPG | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer-monitor.css') }}">
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
                <a class="active" href="{{ route('praktikum') }}">Praktikum</a>
                <a href="{{ route('evaluasi') }}">Evaluasi</a>
                <a href="{{ route('laporan') }}">Unggah Laporan</a>
                <a href="{{ route('asisten-ai') }}">Asisten AI</a>
                <a href="{{ route('profil-dosen') }}">Profil Dosen</a>
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
                    <p>Pengantar prinsip PPG dan perhitungan BPM tersedia di halaman ini; materi resmi tetap menunggu validasi.</p>
                    <a class="button text-button" href="#pilot-learning">Pelajari PPG <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>02</span>
                    <h2>Pre-lab</h2>
                    <p>Tiga pertanyaan pre-lab mandiri tersedia di bawah; soal resmi tetap menunggu validasi.</p>
                    <a class="button text-button" href="#pilot-prelab">Kerjakan Pre-lab <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>03</span>
                    <h2>Jobsheet</h2>
                    <p>Prosedur simulasi dan format pengamatan awal tersedia di bawah; bukan pengganti jobsheet resmi.</p>
                    <a class="button text-button" href="#pilot-jobsheet">Lihat Prosedur <span>→</span></a>
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
                    <p>Monitoring denyut jantung real-time: dukung koneksi BLE Smartwatch dan mode simulasi.</p>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:6px">
                        <a class="button text-button" href="#pilot-monitor-stage">Lihat Monitor di Sini <span>↓</span></a>
                        <a class="button text-button" href="{{ route('monitor-trainer') }}">Buka Monitor Penuh <span>→</span></a>
                    </div>
                </article>

                <article class="content-card" id="interpretasi">
                    <span>06</span>
                    <h2>Interpretasi</h2>
                    <p>Kerangka analisis hasil. Batas normal, aturan interpretasi, dan indikator keberhasilan belum ditetapkan pada tahap ini.</p>
                    <a class="button text-button" href="#pilot-reflection-form">Tulis interpretasi <span>→</span></a>
                </article>

                <article class="content-card" id="refleksi">
                    <span>07</span>
                    <h2>Refleksi</h2>
                    <p>Kerangka refleksi untuk membandingkan tujuan, proses, hasil, kendala, dan perbaikan praktikum.</p>
                    <a class="button text-button" href="#pilot-reflection-form">Tulis refleksi <span>→</span></a>
                </article>

                <article class="content-card">
                    <span>08</span>
                    <h2>Laporan</h2>
                    <p>Tahap dokumentasi akhir yang memuat identitas, data, analisis teknis, dan kesimpulan.</p>
                    <a class="button text-button" href="{{ route('laporan') }}">Buka Laporan <span>→</span></a>
                </article>
            </div>

            <section class="content-card" id="pilot-learning" aria-labelledby="pilot-learning-heading" style="margin-top:1.5rem">
                <p class="eyebrow">Materi pengantar · draf untuk validasi dosen</p>
                <h2 id="pilot-learning-heading">Dasar PPG dan pengukuran heart rate</h2>
                <p>Photoplethysmography (PPG) mengamati perubahan intensitas cahaya yang diterima sensor akibat perubahan volume darah pada jaringan. Puncak gelombang PPG dapat digunakan untuk memperkirakan frekuensi denyut, tetapi kualitas sinyal dipengaruhi gerakan, tekanan kontak sensor, cahaya sekitar, dan kondisi pengukuran.</p>
                <p>Heart rate (BPM) adalah jumlah denyut per menit. Pada interval antar-denyut yang konsisten, perkiraan BPM = 60 / interval (detik). Contoh: interval 0,8 detik menghasilkan sekitar 75 BPM. Ini contoh perhitungan, bukan pengukuran pasien.</p>
                <h3>Tujuan pembelajaran sementara</h3>
                <ol>
                    <li>Menjelaskan prinsip optik PPG dan membedakan data simulasi dengan data sensor fisik.</li>
                    <li>Menghitung BPM dari interval antar-puncak dan menyebutkan sumber ketidakpastian.</li>
                    <li>Mencatat pengamatan, menginterpretasikan keterbatasan, dan menyusun refleksi teknis.</li>
                </ol>
                <h3>Prasyarat dan persiapan</h3>
                <p><strong>Prasyarat:</strong> mahasiswa memahami konsep sensor optik, satuan waktu dalam detik, perhitungan frekuensi, dan perbedaan data simulasi dengan pengukuran fisik. Baca prosedur sebelum membuka trainer.</p>
                <p><strong>Alat dan bahan tahap simulasi:</strong> perangkat dengan browser modern, halaman Monitor Trainer, kalkulator sederhana, dan catatan pengamatan. <strong>Opsional tahap BLE:</strong> smartwatch yang mengimplementasikan BLE Heart Rate Service (UUID 0x180D) serta browser yang mendukung Web Bluetooth. Koneksi BLE tidak sama dengan akuisisi gelombang PPG mentah.</p>
                <h3>Keselamatan dan privasi (draf prosedur)</h3>
                <ul>
                    <li>Gunakan mode simulasi sebagai pilihan awal. Jangan menghubungkan rangkaian elektronik rakitan ke tubuh tanpa persetujuan dosen dan SOP K3.</li>
                    <li>Periksa status sumber data setiap kali mencatat BPM: SIMULASI, BLE WAIT, atau BLE LIVE.</li>
                    <li>Jangan memasukkan nama pasien, identitas subjek, atau data kesehatan pribadi pada catatan browser.</li>
                    <li>Hasil smartwatch dipakai untuk demonstrasi protokol BLE, bukan diagnosis dan bukan bukti akurasi sensor.</li>
                </ul>
                <h3>Pre-lab: cek pemahaman mandiri</h3>
                <form id="pilot-prelab">
                    <fieldset>
                        <legend>1. Pada simulasi BPM, angka yang tampil berasal dari...</legend>
                        <label><input type="radio" name="source" value="sensor" required> Pembacaan sensor tubuh langsung</label>
                        <label><input type="radio" name="source" value="simulation"> Data buatan perangkat lunak</label>
                    </fieldset>
                    <fieldset>
                        <legend>2. Interval antar-denyut 1 detik setara dengan...</legend>
                        <label><input type="radio" name="bpm" value="60" required> 60 BPM</label>
                        <label><input type="radio" name="bpm" value="120"> 120 BPM</label>
                    </fieldset>
                    <fieldset>
                        <legend>3. Gerakan jari saat pengukuran PPG dapat...</legend>
                        <label><input type="radio" name="artifact" value="distort" required> Menimbulkan artefak sinyal</label>
                        <label><input type="radio" name="artifact" value="guarantee"> Menjamin akurasi pembacaan</label>
                    </fieldset>
                    <button class="button primary" type="submit">Periksa pre-lab</button>
                    <button class="button" type="reset">Ulangi pre-lab</button>
                    <p id="pilot-prelab-result" role="status" aria-live="polite"></p>
                </form>
                <h3 id="pilot-jobsheet">Jobsheet pilot · prosedur simulasi</h3>
                <p><strong>Indikator keberhasilan tahap pilot:</strong> mahasiswa dapat mengidentifikasi sumber data dengan benar, menghitung contoh BPM dari interval, mendokumentasikan sedikitnya tiga pengamatan, dan menyampaikan keterbatasan hasil tanpa membuat klaim klinis.</p>
                <p><strong>Alat:</strong> browser modern dan halaman Monitor Trainer. <strong>Keselamatan:</strong> gunakan mode simulasi; jangan menghubungkan rangkaian atau sensor fisik ke tubuh tanpa prosedur K3 dan persetujuan pengampu.</p>
                <ol>
                    <li>Buka <a href="{{ route('monitor-trainer') }}">Monitor Trainer</a> dan identifikasi label sumber data yang sedang aktif.</li>
                    <li>Amati perubahan BPM dan bentuk tren pada mode simulasi; jangan menyebutnya sebagai data fisiologis nyata.</li>
                    <li>Catat sedikitnya tiga kondisi pengamatan beserta sumber data, nilai tampilan, dan keterbatasannya.</li>
                    <li>Bandingkan hasil simulasi dengan rumus BPM = 60 / interval untuk contoh interval yang dipilih.</li>
                    <li>Isi interpretasi dan refleksi di bawah, simpan draf lokal, lalu ekspor TXT untuk dokumentasi.</li>
                </ol>
                <div style="overflow-x:auto">
                    <table style="width:100%;border-collapse:collapse" aria-label="Contoh format tabel pengamatan">
                        <caption>Format pengamatan (contoh; isi nilai aktual pada catatan refleksi)</caption>
                        <thead><tr><th scope="col">Percobaan</th><th scope="col">Sumber data</th><th scope="col">BPM tampil</th><th scope="col">Kendala / artefak</th></tr></thead>
                        <tbody><tr><td>1</td><td>Simulasi / perangkat</td><td>Diisi saat praktik</td><td>Diisi saat praktik</td></tr><tr><td>2</td><td>Simulasi / perangkat</td><td>Diisi saat praktik</td><td>Diisi saat praktik</td></tr><tr><td>3</td><td>Simulasi / perangkat</td><td>Diisi saat praktik</td><td>Diisi saat praktik</td></tr></tbody>
                    </table>
                </div>
                <p><strong>Evaluasi formatif:</strong> jelaskan mengapa angka BPM pada mode simulasi tidak dapat digunakan untuk menyimpulkan kondisi kesehatan seseorang. <strong>Refleksi:</strong> tuliskan satu keterbatasan metode dan satu usulan perbaikan prosedur.</p>
                <h3>Rubrik penilaian formatif sementara</h3>
                <p>Rubrik berikut merupakan <strong>rancangan untuk direview dosen</strong>, bukan nilai akhir mahasiswa. Berikan skor 0 = tidak tampak, 1 = sebagian tepat, atau 2 = tepat disertai alasan/bukti, untuk setiap kriteria.</p>
                <div style="overflow-x:auto">
                    <table style="width:100%;border-collapse:collapse" aria-label="Rubrik formatif pilot PPG">
                        <thead><tr><th scope="col">Kriteria</th><th scope="col">Bukti minimal</th><th scope="col">Skor</th></tr></thead>
                        <tbody>
                            <tr><td>Prinsip dan sumber data</td><td>Membedakan simulasi, BLE, dan sinyal PPG mentah</td><td>0–2</td></tr>
                            <tr><td>Perhitungan BPM</td><td>Menunjukkan rumus 60/interval beserta satuan</td><td>0–2</td></tr>
                            <tr><td>Pengamatan dan K3</td><td>Tiga catatan dengan sumber, nilai, kendala, dan batas keselamatan</td><td>0–2</td></tr>
                            <tr><td>Interpretasi dan refleksi</td><td>Menyebutkan keterbatasan serta satu perbaikan yang masuk akal</td><td>0–2</td></tr>
                        </tbody>
                    </table>
                </div>
                <p><strong>Rentang skor latihan:</strong> 0–8, tanpa batas kelulusan otomatis sampai dosen mengesahkan kriteria.</p>
            </section>

            <section class="content-card" id="pilot-monitor-stage" aria-labelledby="pilot-monitor-heading" style="margin-top:1.5rem">
                <p class="eyebrow">Instrumen Praktikum · Pembacaan Real-time BLE &amp; Simulasi</p>
                <h2 id="pilot-monitor-heading">Monitoring Detak Jantung (Heart Rate / PPG) Smartwatch BLE</h2>
                <p>Amati gelombang pulsa jantung di bawah ini. Tekan tombol <strong>Connect Bluetooth</strong> untuk menghubungkan smartwatch Anda secara nirkabel (Heart Rate Service UUID 0x180D), atau gunakan data simulasi bawaan.</p>

                <div class="trainer-screen">
                    <div class="trainer-screen-top">
                        <span class="trainer-dot"></span>
                        <span>HEART RATE MONITOR · MODE SIMULASI</span>
                        <span class="trainer-status">SIMULASI</span>
                    </div>
                    <div class="simulator-panel">
                        <div class="heart-monitor-stage">
                            <div class="heart-pulse-wrap" aria-label="Animasi detak jantung">
                                <div class="heart-pulse-ring"></div>
                                <div class="heart-beat-icon" aria-hidden="true">
                                    <svg class="heart-anatomy-svg" viewBox="0 0 320 320" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="pilot-heart-muscle" x1="70" y1="110" x2="240" y2="250" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff9b91"/>
                                                <stop offset=".34" stop-color="#e84f5b"/>
                                                <stop offset=".72" stop-color="#b51f3b"/>
                                                <stop offset="1" stop-color="#64172f"/>
                                            </linearGradient>
                                            <linearGradient id="pilot-heart-muscle-light" x1="95" y1="130" x2="188" y2="255" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ffb0a1"/>
                                                <stop offset=".55" stop-color="#ef6670"/>
                                                <stop offset="1" stop-color="#bd304a"/>
                                            </linearGradient>
                                            <linearGradient id="pilot-heart-vessel" x1="125" y1="25" x2="204" y2="135" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ffb0a1"/>
                                                <stop offset=".36" stop-color="#e9575d"/>
                                                <stop offset=".74" stop-color="#a9213d"/>
                                                <stop offset="1" stop-color="#68162f"/>
                                            </linearGradient>
                                            <linearGradient id="pilot-heart-vein" x1="220" y1="60" x2="152" y2="150" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#a9d8ed"/>
                                                <stop offset=".42" stop-color="#538eae"/>
                                                <stop offset="1" stop-color="#274c78"/>
                                            </linearGradient>
                                            <filter id="pilot-heart-shadow" x="35" y="12" width="260" height="300" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
                                                <feGaussianBlur in="SourceAlpha" stdDeviation="7"/>
                                                <feOffset dx="3" dy="8"/>
                                                <feComponentTransfer><feFuncA type="linear" slope=".45"/></feComponentTransfer>
                                                <feMerge><feMergeNode/><feMergeNode in="SourceGraphic"/></feMerge>
                                            </filter>
                                        </defs>
                                        <g filter="url(#pilot-heart-shadow)" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M137 126C126 101 119 79 120 56C120 37 130 24 144 25C159 26 165 41 163 58L160 91" fill="url(#pilot-heart-vein)" stroke="#183d62" stroke-width="5"/>
                                            <path d="M131 55C132 39 139 31 146 32" fill="none" stroke="#d7f0f3" stroke-opacity=".72" stroke-width="5"/>
                                            <path d="M153 122C139 99 130 82 133 60C136 39 151 29 165 37C177 44 175 60 171 77C180 59 190 44 205 48C219 52 221 68 211 83C198 102 180 116 176 135" fill="url(#pilot-heart-vessel)" stroke="#67172f" stroke-width="5"/>
                                            <path d="M143 56C146 42 155 38 162 43M181 73C188 59 198 55 205 58" fill="none" stroke="#ffd0b6" stroke-opacity=".74" stroke-width="5"/>
                                            <path d="M158 122C177 100 195 91 212 99C235 110 239 132 225 149C247 142 263 153 261 172C259 191 240 199 224 196C231 218 218 235 198 235L177 224" fill="url(#pilot-heart-vein)" stroke="#244b72" stroke-width="8"/>
                                            <path d="M196 113C211 105 224 111 228 121M235 163C244 158 251 162 251 169" fill="none" stroke="#c3e8f2" stroke-opacity=".72" stroke-width="5"/>
                                            <path d="M157 112C139 96 118 96 101 108C79 123 77 154 88 184C102 222 132 260 155 284C176 266 209 232 226 195C241 162 236 129 214 111C198 98 176 100 157 112Z" fill="url(#pilot-heart-muscle)" stroke="#65172e" stroke-width="6"/>
                                            <path d="M154 119C137 106 120 107 106 118C89 132 89 155 98 181C109 211 132 241 151 261C159 233 165 197 162 169C160 147 158 130 154 119Z" fill="url(#pilot-heart-muscle-light)" opacity=".92"/>
                                            <path d="M164 121C178 107 195 107 207 117C224 132 224 154 214 181C204 207 185 235 165 258C171 222 175 190 172 164C170 145 167 130 164 121Z" fill="#9f1e3c" opacity=".8"/>
                                            <path d="M159 120C165 145 168 166 166 190C164 215 160 239 155 260" fill="none" stroke="#6b1832" stroke-opacity=".85" stroke-width="7"/>
                                            <path d="M155 126C141 125 127 135 121 150M151 162C137 161 124 169 118 181M178 132C190 128 201 134 206 144M176 170C190 163 203 167 210 177" fill="none" stroke="#ffc0ad" stroke-opacity=".48" stroke-width="4"/>
                                            <path d="M104 127C93 140 95 159 101 174M119 204C128 225 141 240 150 250" fill="none" stroke="#ffe0c5" stroke-opacity=".38" stroke-width="5"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="pulse-line pulse-line-one"></div>
                                <div class="pulse-line pulse-line-two"></div>
                            </div>
                        </div>
                        <div class="trainer-grid heart-only">
                            <div>
                                <span>HEART RATE</span>
                                <strong><span id="heart-rate-value">72</span> <small>bpm</small></strong>
                            </div>
                            <div>
                                <span>STATUS</span>
                                <strong id="heart-rate-status">SIM <small>READY</small></strong>
                            </div>
                        </div>
                    </div>
                    <p class="trainer-disclaimer">Data simulasi atau sensor smartwatch BLE untuk pembelajaran · bukan alat diagnosis medis klinis.</p>
                </div>

                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-top:1.2rem;padding:1.1rem;background:#f0f7f9;border-radius:14px;border:1px solid #c9e3e7">
                    <div>
                        <strong style="color:#0f3856">Sinkronisasi ke Tabel Pengamatan:</strong>
                        <p style="margin:4px 0 0;font-size:0.87rem;color:#496172">Salin pembacaan BPM dan status sumber (Simulasi/BLE) saat ini langsung ke baris pengamatan di bawah.</p>
                    </div>
                    <button type="button" class="button primary" id="btn-sync-bpm-table" style="white-space:nowrap;font-weight:700">
                        <span>↓ Salin BPM ke Pengamatan</span>
                    </button>
                </div>
            </section>

            <section class="content-card" aria-labelledby="pilot-reflection-heading" style="margin-top:1.5rem">
                <h2 id="pilot-reflection-heading">Catatan interpretasi dan refleksi pilot</h2>
                <p>Catat hasil uji simulasi atau perangkat secara mandiri. Isian ini bukan diagnosis, penilaian otomatis, atau bukti validasi hardware. Jangan masukkan data pasien maupun identitas subjek pengukuran.</p>
                <form id="pilot-reflection-form">
                    <h3>Catat tiga pengamatan secara mandiri</h3>
                    <p>Nilai berikut diisi oleh pengguna, tidak diambil otomatis dari sensor maupun dari data simulasi. Pilih sumber yang benar sebelum mencatat.</p>
                    <div style="overflow-x:auto">
                        <table id="pilot-observation-table" style="width:100%;border-collapse:collapse;min-width:650px" aria-label="Tabel input pengamatan pilot">
                            <thead><tr><th scope="col">No.</th><th scope="col">Sumber data</th><th scope="col">BPM tampil</th><th scope="col">Catatan/kendala</th></tr></thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><label for="pilot-source-1">Sumber 1</label><select id="pilot-source-1" style="display:block;width:100%;padding:.5rem"><option value="">Pilih sumber</option><option value="Simulasi">Simulasi</option><option value="BLE smartwatch">BLE smartwatch</option></select></td>
                                    <td><label for="pilot-bpm-1">BPM 1</label><input id="pilot-bpm-1" type="number" min="30" max="240" step="1" inputmode="numeric" style="display:block;width:100%;padding:.5rem" placeholder="30–240"></td>
                                    <td><label for="pilot-note-1">Catatan 1</label><input id="pilot-note-1" type="text" maxlength="240" style="display:block;width:100%;padding:.5rem" placeholder="Gerakan, sinyal, waktu, atau keterbatasan"></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td><label for="pilot-source-2">Sumber 2</label><select id="pilot-source-2" style="display:block;width:100%;padding:.5rem"><option value="">Pilih sumber</option><option value="Simulasi">Simulasi</option><option value="BLE smartwatch">BLE smartwatch</option></select></td>
                                    <td><label for="pilot-bpm-2">BPM 2</label><input id="pilot-bpm-2" type="number" min="30" max="240" step="1" inputmode="numeric" style="display:block;width:100%;padding:.5rem" placeholder="30–240"></td>
                                    <td><label for="pilot-note-2">Catatan 2</label><input id="pilot-note-2" type="text" maxlength="240" style="display:block;width:100%;padding:.5rem" placeholder="Gerakan, sinyal, waktu, atau keterbatasan"></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td><label for="pilot-source-3">Sumber 3</label><select id="pilot-source-3" style="display:block;width:100%;padding:.5rem"><option value="">Pilih sumber</option><option value="Simulasi">Simulasi</option><option value="BLE smartwatch">BLE smartwatch</option></select></td>
                                    <td><label for="pilot-bpm-3">BPM 3</label><input id="pilot-bpm-3" type="number" min="30" max="240" step="1" inputmode="numeric" style="display:block;width:100%;padding:.5rem" placeholder="30–240"></td>
                                    <td><label for="pilot-note-3">Catatan 3</label><input id="pilot-note-3" type="text" maxlength="240" style="display:block;width:100%;padding:.5rem" placeholder="Gerakan, sinyal, waktu, atau keterbatasan"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="display:grid;gap:1rem">
                        <label for="pilot-mode">Mode pengujian
                            <select id="pilot-mode" style="display:block;width:100%;padding:.7rem" required>
                                <option value="">Pilih mode</option>
                                <option value="Simulasi">Simulasi</option>
                                <option value="Perangkat fisik">Perangkat fisik (belum tervalidasi)</option>
                            </select>
                        </label>
                        <label for="pilot-observation">Pengamatan teknis (tanpa data pribadi)
                            <textarea id="pilot-observation" rows="4" maxlength="3000" style="display:block;width:100%;padding:.7rem" placeholder="Contoh: tampilan BPM berubah pada mode simulasi; catat sumber data dan kendala"></textarea>
                        </label>
                        <label for="pilot-interpretation">Interpretasi dan keterbatasan
                            <textarea id="pilot-interpretation" rows="4" maxlength="3000" style="display:block;width:100%;padding:.7rem" placeholder="Jelaskan apa yang dapat dan belum dapat disimpulkan dari pengamatan"></textarea>
                        </label>
                        <label for="pilot-reflection">Refleksi dan rencana perbaikan
                            <textarea id="pilot-reflection" rows="4" maxlength="3000" style="display:block;width:100%;padding:.7rem" placeholder="Tuliskan kesulitan, pembelajaran, dan tindak lanjut"></textarea>
                        </label>
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-top:1rem">
                        <button class="button" type="button" id="pilot-save">Simpan draf lokal</button>
                        <button class="button" type="button" id="pilot-export">Ekspor catatan TXT</button>
                        <button class="button" type="button" id="pilot-clear">Hapus draf</button>
                    </div>
                    <p id="pilot-status" role="status" aria-live="polite">Draf hanya tersimpan di browser ini ketika tombol simpan ditekan.</p>
                </form>
            </section>
        </section>
    </main>

    <script>
        (() => {
            document.getElementById('pilot-prelab').addEventListener('submit', event => {
                event.preventDefault();
                const form = new FormData(event.currentTarget);
                const questions = [
                    ['source', 'simulation', 'Soal 1: data simulasi dibuat perangkat lunak, bukan sensor tubuh.'],
                    ['bpm', '60', 'Soal 2: BPM = 60/interval (detik), jadi 1 detik setara 60 BPM.'],
                    ['artifact', 'distort', 'Soal 3: gerakan jari dapat menimbulkan artefak pada PPG.'],
                ];
                const incorrect = questions.filter(([name, answer]) => form.get(name) !== answer);
                const score = questions.length - incorrect.length;
                document.getElementById('pilot-prelab-result').textContent =
                    'Skor latihan: ' + score + '/3. ' +
                    (incorrect.length === 0
                        ? 'Semua jawaban tepat. Lanjutkan ke prosedur simulasi.'
                        : incorrect.map(([, , explanation]) => explanation).join(' '));
            });
            document.getElementById('pilot-prelab').addEventListener('reset', () => {
                document.getElementById('pilot-prelab-result').textContent = '';
            });
            const key = 'pilot-heart-rate-reflection-v1';
            const fields = ['pilot-mode', 'pilot-observation', 'pilot-interpretation', 'pilot-reflection',
                ...[1, 2, 3].flatMap(i => ['pilot-source-' + i, 'pilot-bpm-' + i, 'pilot-note-' + i])
            ];
            const status = document.getElementById('pilot-status');
            const getData = () => Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));
            const setData = data => {
                const safeData = data && typeof data === 'object' && !Array.isArray(data) ? data : {};
                fields.forEach(id => {
                    const element = document.getElementById(id);
                    const value = typeof safeData[id] === 'string' ? safeData[id] : '';
                    element.value = value.slice(0, element.maxLength > 0 ? element.maxLength : 3000);
                });
            };
            try {
                const saved = localStorage.getItem(key);
                if (saved) setData(JSON.parse(saved));
            } catch {
                status.textContent = 'Penyimpanan lokal tidak tersedia atau draf tidak dapat dibaca.';
            }
            document.getElementById('pilot-reflection-form').addEventListener('input', () => {
                status.textContent = 'Ada perubahan yang belum disimpan. Klik Simpan draf lokal atau Ekspor TXT.';
            });
            document.getElementById('pilot-save').addEventListener('click', () => {
                try {
                    localStorage.setItem(key, JSON.stringify(getData()));
                    status.textContent = 'Draf tersimpan pada browser ini. Ekspor TXT untuk cadangan.';
                } catch {
                    status.textContent = 'Gagal menyimpan draf. Gunakan ekspor TXT.';
                }
            });
            document.getElementById('pilot-export').addEventListener('click', () => {
                const data = getData();
                const labels = {
                    'pilot-mode': 'Mode pengujian',
                    'pilot-observation': 'Pengamatan teknis',
                    'pilot-interpretation': 'Interpretasi dan keterbatasan',
                    'pilot-reflection': 'Refleksi dan rencana perbaikan',
                    ...Object.fromEntries([1, 2, 3].flatMap(i => [
                        ['pilot-source-' + i, 'Sumber data pengamatan ' + i],
                        ['pilot-bpm-' + i, 'Nilai BPM pengamatan ' + i],
                        ['pilot-note-' + i, 'Kendala pengamatan ' + i]
                    ]))
                };
                const content = ['CATATAN PILOT HEART RATE / PPG', 'Status: catatan mandiri, bukan validasi hardware atau diagnosis', '',
                    ...fields.flatMap(id => [labels[id] + ':', data[id] || '(belum diisi)', ''])].join('\n');
                const url = URL.createObjectURL(new Blob([content], { type: 'text/plain;charset=utf-8' }));
                const link = document.createElement('a');
                link.href = url;
                link.download = 'catatan-pilot-heart-rate.txt';
                link.click();
                setTimeout(() => URL.revokeObjectURL(url), 1000);
                status.textContent = 'Catatan diekspor sebagai TXT. Periksa folder unduhan browser.';
            });
            document.getElementById('pilot-clear').addEventListener('click', () => {
                if (!confirm('Hapus seluruh catatan pilot yang tersimpan pada browser ini?')) return;
                try { localStorage.removeItem(key); } catch {}
                document.getElementById('pilot-reflection-form').reset();
                status.textContent = 'Isian dan draf lokal telah dibersihkan.';
            });

            const syncBtn = document.getElementById('btn-sync-bpm-table');
            if (syncBtn) {
                syncBtn.addEventListener('click', () => {
                    const valElem = document.getElementById('heart-rate-value');
                    const statusElem = document.getElementById('heart-rate-status');
                    const currentBpm = parseInt(valElem?.textContent || '72', 10);
                    const isBle = (statusElem?.textContent || '').includes('BLE');
                    const sourceVal = isBle ? 'BLE smartwatch' : 'Simulasi';

                    let targetRow = 1;
                    for (let i = 1; i <= 3; i++) {
                        const bpmInput = document.getElementById('pilot-bpm-' + i);
                        if (!bpmInput?.value) {
                            targetRow = i;
                            break;
                        }
                    }

                    const sourceSelect = document.getElementById('pilot-source-' + targetRow);
                    const bpmInput = document.getElementById('pilot-bpm-' + targetRow);
                    const noteInput = document.getElementById('pilot-note-' + targetRow);

                    if (sourceSelect) sourceSelect.value = sourceVal;
                    if (bpmInput) bpmInput.value = currentBpm;
                    if (noteInput && !noteInput.value) {
                        noteInput.value = isBle ? 'Terbaca dari koneksi BLE Smartwatch' : 'Nilai dari mode simulasi pembelajaran';
                    }

                    bpmInput?.dispatchEvent(new Event('input', { bubbles: true }));
                    document.getElementById('pilot-observation-table')?.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    const originalText = syncBtn.textContent;
                    syncBtn.textContent = '✓ Tersalin ke Baris ' + targetRow + ' (' + currentBpm + ' BPM)!';
                    setTimeout(() => {
                        syncBtn.textContent = originalText;
                    }, 2400);
                });
            }
        })();
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
