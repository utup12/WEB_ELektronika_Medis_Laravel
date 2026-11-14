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
                    <p>Mode simulasi tersedia. Uji BLE fisik dan bukti kestabilan koneksi tetap menjadi pekerjaan mahasiswa.</p>
                    <a class="button text-button" href="{{ route('monitor-trainer') }}">Buka Monitor <span>→</span></a>
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
        })();
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
