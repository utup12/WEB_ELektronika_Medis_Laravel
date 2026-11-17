<x-layouts.platform title="Evaluasi | Praktik Elektronika Medis">
<style>
.practice-shell{margin-bottom:2.5rem;padding:1.5rem;border:1px solid #d5e2ef;border-radius:18px;background:#fbfdfd;box-shadow:0 12px 28px rgba(0,54,104,.05)}
.practice-banner{display:inline-block;padding:4px 10px;border-radius:999px;background:#fff4d6;color:#7a5300;font:600 .75rem 'DM Mono',monospace;text-transform:uppercase;letter-spacing:.04em}
.practice-controls{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:end;margin:1rem 0 1.25rem}
.practice-controls label{display:grid;gap:6px;font-weight:700}
.practice-controls select{width:100%;padding:10px 12px;border:1px solid #b8cadb;border-radius:10px;background:#fff;font:inherit}
.practice-header{padding:1rem 1.15rem;border:1px solid #dbe6f2;border-radius:12px;background:#fff;margin-bottom:1.15rem}
.practice-header span{color:#168885;font:600 .76rem 'DM Mono',monospace;text-transform:uppercase}
.practice-header h2{margin:.35rem 0 .25rem}
.practice-header p{margin:0;color:#526577;font-size:.92rem}
.practice-question{margin:0 0 1rem;padding:1rem 1.15rem;border:1px solid #dce6f0;border-radius:12px;background:#fff}
.practice-question legend{font-weight:700;padding:0 4px;line-height:1.5}
.practice-question.is-correct{border-color:#1c8a5c}
.practice-question.is-wrong{border-color:#c44949}
.practice-options{display:grid;gap:8px;margin-top:.75rem}
.practice-option{display:flex;align-items:flex-start;gap:10px;padding:9px 11px;border:1px solid #e1eaf3;border-radius:9px;background:#f9fcff;cursor:pointer;font-weight:500;line-height:1.5}
.practice-option:hover{border-color:#2c74b3;background:#eef6ff}
.practice-option input{width:auto;margin-top:4px;flex:0 0 auto}
.practice-feedback{margin-top:.75rem;padding:.75rem .9rem;border-radius:8px;font-size:.9rem;line-height:1.5}
.practice-feedback.ok{background:#e7f6ee;color:#115e3d}
.practice-feedback.bad{background:#ffefef;color:#8e2222}
.practice-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:1rem}
.practice-result{margin-top:1.25rem;padding:1.15rem;border-radius:14px}
.practice-result.is-ready{border:1px solid #168885;background:#ecf9f8}
.practice-score-row{display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:12px}
.practice-score-label{display:block;color:#0f6c69;font:600 .78rem 'DM Mono',monospace;text-transform:uppercase}
.practice-score-value{display:block;font-size:1.75rem;color:#0b3b62}
.practice-score-note{margin:0;max-width:520px;color:#334a5e;line-height:1.5}
html[data-theme='dark'] .practice-shell,body.dark-mode .practice-shell{background:#101720;border-color:#2a3945}
html[data-theme='dark'] .practice-header,html[data-theme='dark'] .practice-question,body.dark-mode .practice-header,body.dark-mode .practice-question{background:#131d28;border-color:#2c3e4f}
html[data-theme='dark'] .practice-controls select{background:#131d28;border-color:#2c3e4f;color:#eef6f8}
html[data-theme='dark'] .practice-option{background:#172330;border-color:#2e4154;color:#dce8ee}
html[data-theme='dark'] .practice-result.is-ready{background:#11292d;border-color:#2a8d89}
html[data-theme='dark'] .practice-score-value{color:#75e3d5}
html[data-theme='dark'] .practice-score-note{color:#b8cdd6}
@media (max-width:680px){.practice-controls{grid-template-columns:1fr}}
</style>

<section class="page-hero">
    <p class="eyebrow">Evaluasi &amp; latihan mandiri</p>
    <h1>Evaluasi Pembelajaran</h1>
    <p>Kerjakan latihan pilihan ganda per jobsheet (10 soal per modul) untuk mengukur pemahaman secara langsung dengan skor instan, atau simpan pre-lab kesiapan praktikum ke akun Anda.</p>
</section>

<section class="page-content">
    <section class="practice-shell" id="latihan-jobsheet" aria-labelledby="latihan-jobsheet-heading">
        <span class="practice-banner">Hanya untuk latihan · tidak masuk nilai resmi</span>
        <h2 id="latihan-jobsheet-heading" style="margin-top:.65rem">Latihan Soal per Jobsheet (10 Soal Pilihan Ganda)</h2>
        <p style="margin-top:0;color:#526577">Pilih modul jobsheet di bawah ini, jawab seluruh 10 soal pilihan ganda, lalu tekan <strong>Selesai &amp; Lihat Skor</strong>. Skor dan pembahasan langsung tampil di layar dan tidak dicatat ke nilai resmi mata kuliah.</p>

        <div class="practice-controls">
            <label for="practice-module-select">
                Pilih Jobsheet (14 modul tersedia)
                <select id="practice-module-select">
                    @foreach ($practiceQuizzes as $quizModule)
                        <option value="{{ $quizModule['slug'] }}">Jobsheet {{ $quizModule['number'] }} · {{ $quizModule['title'] }} ({{ $quizModule['group'] }})</option>
                    @endforeach
                </select>
            </label>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button type="button" class="button outline" id="practice-shuffle-btn">Acak Urutan Soal</button>
                <button type="button" class="button outline" id="practice-reset-btn">Ulangi Modul Ini</button>
            </div>
        </div>

        <div class="practice-header">
            <span id="practice-module-group">Penguat Sinyal · 10 Soal Pilihan Ganda</span>
            <h2 id="practice-module-title">Jobsheet 1: Penguat Instrumentasi</h2>
            <p id="practice-module-meta">Latihan mandiri — skor langsung muncul setelah selesai dan tidak masuk nilai resmi.</p>
        </div>

        <form id="practice-quiz-form">
            <div id="practice-quiz-container">
                <p>Memuat soal latihan…</p>
            </div>
            <div id="practice-quiz-result" class="practice-result" hidden aria-live="polite"></div>
            <div class="practice-actions">
                <button type="submit" class="button primary">Selesai &amp; Lihat Skor <span>→</span></button>
                <button type="button" class="button outline" id="practice-next-btn">Lanjut Jobsheet Berikutnya →</button>
            </div>
        </form>
    </section>

    <section class="lecturer-section" aria-labelledby="prelab-heading">
        <h2 id="prelab-heading">Pre-lab Kesiapan Praktikum</h2>
        <p>Tiga pertanyaan kesiapan praktikum resmi yang tersimpan pada akun mahasiswa dan dapat dipantau oleh dosen. Untuk latihan alur pilot PPG, buka <a href="{{ route('pilot.heart-rate') }}#pilot-prelab">Pre-lab Pilot PPG</a>.</p>

        @auth
            <form class="learning-panel quiz-panel" action="{{ route('evaluasi.store') }}" method="POST">
                @csrf
                <h3>Latihan Kesiapan</h3>
                @if(session('success'))
                    <p class="notice success">{{ session('success') }}</p>
                @endif
                <label>1. Langkah pertama sebelum menggunakan peralatan?
                    <select name="safety" required>
                        <option value="">Pilih jawaban</option>
                        <option value="correct">Memeriksa prosedur keselamatan dan kondisi alat.</option>
                        <option value="wrong">Langsung menghubungkan semua rangkaian.</option>
                    </select>
                </label>
                <label>2. Pengkondisian sinyal membantu sensor diproses dengan baik.
                    <select name="signal" required>
                        <option value="">Pilih jawaban</option>
                        <option value="correct">Benar</option>
                        <option value="wrong">Salah</option>
                    </select>
                </label>
                <label>3. Data dan pembahasan hasil perlu dicantumkan pada laporan.
                    <select name="report" required>
                        <option value="">Pilih jawaban</option>
                        <option value="correct">Benar</option>
                        <option value="wrong">Salah</option>
                    </select>
                </label>
                <button class="button primary">Simpan Hasil <span>→</span></button>
            </form>

            <section class="lecturer-section">
                <h3>Riwayat evaluasi</h3>
                <table class="review-table">
                    <thead><tr><th>Waktu</th><th>Nilai</th><th>Modul</th></tr></thead>
                    <tbody>
                        @forelse($attempts as $attempt)
                            <tr><td>{{ $attempt->submitted_at->format('d M Y H:i') }}</td><td>{{ $attempt->score }}/{{ $attempt->total }}</td><td>{{ $attempt->module }}</td></tr>
                        @empty
                            <tr><td colspan="3">Belum ada hasil evaluasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        @else
            <div class="ai-boundary">
                <strong>Masuk akun untuk menyimpan Pre-lab Kesiapan</strong>
                Latihan 10 soal per jobsheet di atas dapat dikerjakan bebas tanpa login. Untuk menyimpan skor pre-lab kesiapan ke sistem dosen, silakan <a href="{{ route('masuk') }}">masuk ke akun mahasiswa</a>.
            </div>
        @endauth
    </section>
</section>

<script id="jobsheet-practice-data" type="application/json">{!! json_encode($practiceQuizzes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
<script defer src="{{ asset('js/evaluasi-practice.js') }}"></script>
</x-layouts.platform>
