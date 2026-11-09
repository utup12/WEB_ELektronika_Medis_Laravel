<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Candidate Pilot Heart Rate / PPG | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">

    <style>
        .pilot-record{margin-top:2rem;padding:clamp(1rem,3vw,2rem);background:var(--card-bg,#fff);border:1px solid #d6dfe9;border-radius:18px;color:var(--text-color,#1b2938)}
        .pilot-record-heading{display:flex;gap:1rem;align-items:flex-start;justify-content:space-between;flex-wrap:wrap}
        .pilot-record-heading h2{margin:.2rem 0 .6rem}
        .pilot-record-heading p{max-width:70ch}
        .pilot-record-tag{font-size:.75rem;border:1px solid #c6d5e5;border-radius:999px;padding:.4rem .8rem;white-space:nowrap}
        .pilot-observation-form{margin-top:1rem}
        .pilot-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .pilot-observation-form label{display:flex;flex-direction:column;gap:.4rem;font-weight:600}
        .pilot-observation-form input,.pilot-observation-form select,.pilot-observation-form textarea{width:100%;max-width:100%;box-sizing:border-box;padding:.75rem;border:1px solid #a9b8c8;border-radius:9px;background:var(--card-bg,#fff);color:inherit;font:inherit}
        .pilot-full-label{margin-top:1rem}
        .pilot-actions{display:flex;gap:.7rem;flex-wrap:wrap;margin-top:1.2rem}
        .pilot-actions button:disabled{opacity:.5;cursor:not-allowed}
        .pilot-table-scroll{overflow-x:auto;margin-top:1.25rem}
        .pilot-table{width:100%;border-collapse:collapse;font-size:.9rem;min-width:650px}
        .pilot-table caption{text-align:left;font-weight:700;margin-bottom:.5rem}
        .pilot-table th,.pilot-table td{padding:.7rem;text-align:left;vertical-align:top;border-bottom:1px solid #d6dfe9;overflow-wrap:anywhere}
        .pilot-table th{background:rgba(120,145,170,.1)}
        @media(max-width:640px){.pilot-form-grid{grid-template-columns:1fr}.pilot-record-tag{white-space:normal}}
    </style>
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

            <section class="pilot-record" aria-labelledby="pilot-record-title">
                <div class="pilot-record-heading">
                    <div>
                        <p class="eyebrow">Instrumen latihan · penyimpanan lokal sementara</p>
                        <h2 id="pilot-record-title">Catatan Pengamatan Heart Rate / PPG</h2>
                        <p>Catat pengukuran dari simulasi atau perangkat secara terpisah. Data hanya disimpan selama halaman terbuka; unduh CSV sebelum meninggalkan halaman.</p>
                    </div>
                    <span class="pilot-record-tag">Bukan data klinis</span>
                </div>
                <form id="pilot-observation-form" class="pilot-observation-form">
                    <div class="pilot-form-grid">
                        <label>Waktu pengamatan
                            <input id="pilot-time" name="time" type="datetime-local" required>
                        </label>
                        <label>Sumber data
                            <select id="pilot-source" name="source" required>
                                <option value="">Pilih sumber</option>
                                <option value="Simulasi">Simulasi</option>
                                <option value="Sensor fisik">Sensor fisik (belum tervalidasi)</option>
                            </select>
                        </label>
                        <label>Heart rate (bpm)
                            <input id="pilot-bpm" name="bpm" type="number" min="1" max="300" step="1" placeholder="Mis. 72" required>
                        </label>
                        <label>Kondisi pengamatan
                            <input id="pilot-condition" name="condition" type="text" maxlength="120" placeholder="Mis. saat istirahat" required>
                        </label>
                    </div>
                    <label class="pilot-full-label">Catatan sinyal / kendala
                        <textarea id="pilot-notes" name="notes" maxlength="800" rows="3" placeholder="Jelaskan kestabilan sinyal, gangguan gerakan, atau kendala teknis."></textarea>
                    </label>
                    <label class="pilot-full-label">Refleksi praktikum
                        <textarea id="pilot-reflection" name="reflection" maxlength="800" rows="3" placeholder="Apa yang dipelajari, keterbatasan pengukuran, dan perbaikan berikutnya?"></textarea>
                    </label>
                    <div class="pilot-actions">
                        <button class="button primary" type="submit">Tambahkan catatan</button>
                        <button class="button text-button" type="button" id="pilot-download" disabled>Unduh CSV</button>
                        <button class="button text-button" type="button" id="pilot-clear" disabled>Hapus catatan</button>
                    </div>
                    <p id="pilot-feedback" role="status" aria-live="polite">Belum ada catatan pengamatan.</p>
                </form>
                <div class="pilot-table-scroll">
                    <table class="pilot-table">
                        <caption>Daftar catatan pada sesi halaman ini</caption>
                        <thead><tr><th scope="col">Waktu</th><th scope="col">Sumber</th><th scope="col">BPM</th><th scope="col">Kondisi</th><th scope="col">Catatan</th><th scope="col">Refleksi</th></tr></thead>
                        <tbody id="pilot-observations"><tr><td colspan="6">Belum ada data.</td></tr></tbody>
                    </table>
                </div>
                <p class="trainer-disclaimer">Nilai BPM dari simulasi bukan pengukuran fisiologis. Hasil dari sensor fisik tetap memerlukan verifikasi perangkat, metode, dan prosedur oleh pengampu. Lembar ini tidak digunakan untuk diagnosis.</p>
            </section>
        </section>
    </main>


    <script>
    (() => {
        'use strict';
        const form = document.getElementById('pilot-observation-form');
        const body = document.getElementById('pilot-observations');
        const feedback = document.getElementById('pilot-feedback');
        const download = document.getElementById('pilot-download');
        const clear = document.getElementById('pilot-clear');
        const rows = [];
        const columns = ['Waktu', 'Sumber', 'BPM', 'Kondisi', 'Catatan', 'Refleksi'];
        const get = id => document.getElementById(id).value.trim();
        const render = () => {
            body.replaceChildren();
            if (!rows.length) {
                const tr = body.insertRow();
                const td = tr.insertCell();
                td.colSpan = columns.length;
                td.textContent = 'Belum ada data.';
            } else {
                for (const row of rows) {
                    const tr = body.insertRow();
                    for (const value of row) {
                        const td = tr.insertCell();
                        td.textContent = value;
                    }
                }
            }
            download.disabled = clear.disabled = rows.length === 0;
            feedback.textContent = rows.length + ' catatan dalam sesi ini. Unduh CSV untuk menyimpan permanen.';
        };
        // Prefix values interpreted as formulas by spreadsheet software.
        const csvCell = value => {
            let string = String(value).replace(/\r\n?/g, '\n');
            if (/^[\s]*[=+@-]/.test(string)) string = "'" + string;
            return '"' + string.replace(/"/g, '""') + '"';
        };
        form.addEventListener('submit', event => {
            event.preventDefault();
            if (!form.reportValidity()) return;
            const bpm = Number(get('pilot-bpm'));
            if (!Number.isInteger(bpm) || bpm < 1 || bpm > 300) {
                feedback.textContent = 'Masukkan BPM bilangan bulat antara 1 dan 300.';
                return;
            }
            rows.push([
                get('pilot-time'), get('pilot-source'), String(bpm),
                get('pilot-condition'), get('pilot-notes'), get('pilot-reflection')
            ]);
            const time = get('pilot-time');
            const source = get('pilot-source');
            form.reset();
            document.getElementById('pilot-time').value = time;
            document.getElementById('pilot-source').value = source;
            render();
        });
        download.addEventListener('click', () => {
            if (!rows.length) return;
            const csv = '\uFEFF' + [columns, ...rows].map(row => row.map(csvCell).join(',')).join('\r\n');
            const url = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
            const link = document.createElement('a');
            link.href = url;
            link.download = 'pengamatan-heart-rate-ppg.csv';
            document.body.appendChild(link);
            link.click();
            link.remove();
            setTimeout(() => URL.revokeObjectURL(url), 1000);
        });
        clear.addEventListener('click', () => {
            if (!rows.length || !window.confirm('Hapus semua catatan pada sesi ini? Data yang belum diunduh tidak dapat dipulihkan.')) return;
            rows.length = 0;
            render();
        });
        const date = new Date();
        const local = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        document.getElementById('pilot-time').value = local;
    })();
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
