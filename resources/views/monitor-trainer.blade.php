<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tampilan Trainer | Praktik Elektronika Medis</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
        <link rel="stylesheet" href="{{ asset('css/trainer-monitor.css') }}">
    <link rel="stylesheet" href="/css/a11y.css"></head>
    <body><a class="skip-link" href="#main-content">Lewati ke konten utama</a>
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
                <button class="menu-toggle" aria-label="Buka menu" aria-expanded="false">
                    <span></span><span></span>
                </button>
                <nav class="main-nav" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('materi') }}">Materi</a>
                    <a href="{{ route('praktikum') }}">Praktikum</a>
                    <a class="active" href="{{ route('monitor-trainer') }}">Monitor Heart Rate (BLE)</a>
                    <a href="{{ route('evaluasi') }}">Evaluasi</a>
                    <a href="{{ route('laporan') }}">Unggah Laporan</a>
                    <a href="{{ route('asisten-ai') }}">Asisten AI</a>
                    <a href="{{ route('profil-dosen') }}">Profil Dosen</a>
                </nav>
            </div>
        </header>
        <main id="main-content" tabindex="-1">
            <section class="page-hero">
                <p class="eyebrow">Praktikum · Instrumentasi Digital &amp; Telemetri BLE</p>
                <h1>Monitor LCD &amp; Smartwatch BLE</h1>
                <p>Platform monitoring detak jantung (Heart Rate / PPG) real-time. Hubungkan smartwatch atau modul sensor detak jantung melalui Bluetooth Low Energy (Heart Rate Service UUID 0x180D), atau pelajari respon dinamis pada mode simulasi otomatis.</p>
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px">
                    <a class="button outline" href="{{ route('pilot.heart-rate') }}">Buka Alur Praktikum Smartwatch &amp; PPG <span>→</span></a>
                    <a class="button outline" href="{{ route('praktikum') }}">Daftar Modul Praktikum</a>
                </div>
            </section>
            <section class="page-content">
                <div class="trainer-screen">
                    <div class="trainer-screen-top">
                        <span class="trainer-dot"></span>
                        <span>HEART RATE MONITOR · MODE SIMULASI</span>
                        <span class="trainer-status">SIMULASI</span>
                    </div>
                    <div class="simulator-panel">
                        <div class="heart-monitor-stage">
                            <div class="heart-pulse-wrap" aria-label="Animasi detak jantung simulasi">
                                <div class="heart-pulse-ring"></div>
                                <div class="heart-beat-icon" aria-hidden="true">
                                    <svg class="heart-anatomy-svg" viewBox="0 0 320 320" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="heart-muscle" x1="70" y1="110" x2="240" y2="250" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff9b91"/>
                                                <stop offset=".34" stop-color="#e84f5b"/>
                                                <stop offset=".72" stop-color="#b51f3b"/>
                                                <stop offset="1" stop-color="#64172f"/>
                                            </linearGradient>
                                            <linearGradient id="heart-muscle-light" x1="95" y1="130" x2="188" y2="255" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ffb0a1"/>
                                                <stop offset=".55" stop-color="#ef6670"/>
                                                <stop offset="1" stop-color="#bd304a"/>
                                            </linearGradient>
                                            <linearGradient id="heart-vessel" x1="125" y1="25" x2="204" y2="135" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ffb0a1"/>
                                                <stop offset=".36" stop-color="#e9575d"/>
                                                <stop offset=".74" stop-color="#a9213d"/>
                                                <stop offset="1" stop-color="#68162f"/>
                                            </linearGradient>
                                            <linearGradient id="heart-vein" x1="220" y1="60" x2="152" y2="150" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#a9d8ed"/>
                                                <stop offset=".42" stop-color="#538eae"/>
                                                <stop offset="1" stop-color="#274c78"/>
                                            </linearGradient>
                                            <filter id="heart-shadow" x="35" y="12" width="260" height="300" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
                                                <feGaussianBlur in="SourceAlpha" stdDeviation="7"/>
                                                <feOffset dx="3" dy="8"/>
                                                <feComponentTransfer>
                                                    <feFuncA type="linear" slope=".45"/>
                                                </feComponentTransfer>
                                                <feMerge>
                                                    <feMergeNode/>
                                                    <feMergeNode in="SourceGraphic"/>
                                                </feMerge>
                                            </filter>
                                        </defs>
                                        <g filter="url(#heart-shadow)" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M137 126C126 101 119 79 120 56C120 37 130 24 144 25C159 26 165 41 163 58L160 91" fill="url(#heart-vein)" stroke="#183d62" stroke-width="5"/>
                                            <path d="M131 55C132 39 139 31 146 32" fill="none" stroke="#d7f0f3" stroke-opacity=".72" stroke-width="5"/>
                                            <path d="M153 122C139 99 130 82 133 60C136 39 151 29 165 37C177 44 175 60 171 77C180 59 190 44 205 48C219 52 221 68 211 83C198 102 180 116 176 135" fill="url(#heart-vessel)" stroke="#67172f" stroke-width="5"/>
                                            <path d="M143 56C146 42 155 38 162 43M181 73C188 59 198 55 205 58" fill="none" stroke="#ffd0b6" stroke-opacity=".74" stroke-width="5"/>
                                            <path d="M158 122C177 100 195 91 212 99C235 110 239 132 225 149C247 142 263 153 261 172C259 191 240 199 224 196C231 218 218 235 198 235L177 224" fill="url(#heart-vein)" stroke="#244b72" stroke-width="8"/>
                                            <path d="M196 113C211 105 224 111 228 121M235 163C244 158 251 162 251 169" fill="none" stroke="#c3e8f2" stroke-opacity=".72" stroke-width="5"/>
                                            <path d="M157 112C139 96 118 96 101 108C79 123 77 154 88 184C102 222 132 260 155 284C176 266 209 232 226 195C241 162 236 129 214 111C198 98 176 100 157 112Z" fill="url(#heart-muscle)" stroke="#65172e" stroke-width="6"/>
                                            <path d="M154 119C137 106 120 107 106 118C89 132 89 155 98 181C109 211 132 241 151 261C159 233 165 197 162 169C160 147 158 130 154 119Z" fill="url(#heart-muscle-light)" opacity=".92"/>
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
                    <p class="trainer-disclaimer">Data simulasi atau sensor untuk pembelajaran · bukan hasil diagnosis atau pemantauan klinis.</p>
                </div>
                <div class="ai-boundary">
                    <strong>Status integrasi</strong>
                    Untuk membaca BPM nyata, gunakan smartwatch atau sensor yang menyediakan Bluetooth Low Energy (BLE) Heart Rate Service (UUID 0x180D). Perangkat training kit memerlukan dukungan layanan BLE tersebut; koneksi ke hardware belum otomatis tersedia.
                </div>

                <div style="margin-top:1.5rem;padding:1.4rem;background:#ffffff;border:1px solid #d4e3ec;border-radius:16px;box-shadow:0 8px 24px rgba(8,36,64,0.06)">
                    <h3 style="margin-top:0;color:#0b3b62;font-size:1.15rem">Panduan Menghubungkan Smartwatch (BLE Heart Rate)</h3>
                    <p style="margin:6px 0 14px;color:#496172;font-size:0.9rem">Pastikan Bluetooth laptop/komputer Anda aktif dan gunakan browser modern yang mendukung Web Bluetooth API (Google Chrome atau Microsoft Edge melalui protokol HTTPS):</p>
                    <ol style="margin:0 0 14px 1.2rem;padding:0;color:#284558;font-size:0.9rem;line-height:1.7">
                        <li><strong>Garmin Watch:</strong> Masuk ke menu <em>Settings &rarr; Sensors &amp; Accessories &rarr; Wrist Heart Rate &rarr; Broadcast Heart Rate</em>, lalu pilih <em>Start</em>.</li>
                        <li><strong>Polar / Chest Strap (H9, H10, Verity):</strong> Pasang strap pada dada/lengan; sensor BLE aktif secara otomatis.</li>
                        <li><strong>Apple Watch / Wear OS:</strong> Buka aplikasi broadcast denyut BLE pihak ketiga (seperti <em>HeartCast</em> atau <em>BLE Heart Rate Transmitter</em>).</li>
                        <li><strong>Smartphone / Simulator BLE:</strong> Anda juga dapat menguji menggunakan aplikasi <em>nRF Connect for Mobile</em> (tersedia di Android &amp; iOS) dengan mengaktifkan mode server *Heart Rate Service*.</li>
                        <li>Klik tombol <strong>Connect Bluetooth</strong> pada monitor di atas, pilih perangkat smartwatch Anda pada jendela pop-up browser, lalu klik <strong>Pair</strong>.</li>
                    </ol>
                    <div style="display:flex;gap:12px;flex-wrap:wrap">
                        <a class="button primary" href="{{ route('pilot.heart-rate') }}#pilot-monitor-stage">Gunakan di Lembar Praktikum PPG <span>→</span></a>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
