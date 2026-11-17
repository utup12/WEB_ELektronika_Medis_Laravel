<x-layouts.platform title="Praktikum | Praktik Elektronika Medis">
<style>
.praktikum-jump{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px}
.sheet-edition{margin:2rem 0;padding:1.45rem;border:1px solid #d9e3ef;border-radius:18px;background:#fff;box-shadow:0 12px 30px rgba(0,54,104,.06)}
.sheet-meta{color:#586779;font-size:.94rem}
.sheet-note{border-left:4px solid #b87b16;padding:.8rem 1rem;background:#fff8e8;margin-top:1rem;color:#3d2f0c}
.sheet-edition h3{display:flex;align-items:center;gap:.55rem;margin-top:1.5rem}
.sheet-edition h3:before{content:'⌁';display:grid;place-items:center;width:24px;height:24px;border-radius:7px;background:#e7f2fd;color:#004b93;font-weight:800}
.sheet-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(265px,1fr));gap:1rem;margin-top:1rem}
.sheet-card{display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden;padding:1.15rem;border:1px solid #d6e2f0;border-radius:15px;background:linear-gradient(145deg,#fff,#f2f8ff);transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease}
.sheet-card:before{content:'';position:absolute;inset:0 0 auto;height:4px;background:linear-gradient(90deg,#004b93,#00a4a4,#f7c948);opacity:.85}
.sheet-card:hover,.sheet-card:focus-within{transform:translateY(-4px);border-color:#2866aa;box-shadow:0 14px 25px rgba(0,54,104,.14)}
.sheet-card-head{display:flex;align-items:center;gap:.75rem;margin:.1rem 0 .55rem}
.sheet-card-head small{flex:1;color:#4c6782}
.sheet-card-icon{display:grid;place-items:center;width:42px;height:42px;flex:0 0 42px;border-radius:13px;background:linear-gradient(135deg,#e4f1ff,#fff4c7);color:#004b93;border:1px solid #d3e5f7;font-size:1.35rem;font-weight:800;box-shadow:inset 0 1px #fff}
.sheet-card strong{display:block;margin:.25rem 0;font-size:1.05rem}
.sheet-card p{margin:.45rem 0 1rem;line-height:1.6;color:#435669}
.sheet-card-cta{align-self:flex-start}
.simulation-card{margin-top:2.2rem;padding:1.6rem;border:1px solid #b8dce0;border-radius:18px;background:linear-gradient(145deg,#f4fbfb,#eef6ff)}
.simulation-badge{display:inline-block;padding:4px 10px;border-radius:999px;background:#e0f4f3;color:#0f6c69;font:600 .75rem 'DM Mono',monospace;text-transform:uppercase;letter-spacing:.04em}
.simulation-card h2{margin:.75rem 0 .5rem}
.simulation-card p{max-width:720px;line-height:1.65;color:#3d5366}
.simulation-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:1.1rem}
html[data-theme='dark'] .sheet-edition,body.dark-mode .sheet-edition{background:#101720;border-color:#2a3945}
html[data-theme='dark'] .sheet-meta,body.dark-mode .sheet-meta{color:#adbdc6}
html[data-theme='dark'] .sheet-note,body.dark-mode .sheet-note{background:#231d10;border-left-color:#d89c2e;color:#f4dfaa}
html[data-theme='dark'] .sheet-edition h3:before{background:#173f60;color:#f7d766}
html[data-theme='dark'] .sheet-card,body.dark-mode .sheet-card{background:#13202d;border-color:#2a3e50}
html[data-theme='dark'] .sheet-card-head small,html[data-theme='dark'] .sheet-card p{color:#b6c8d3}
html[data-theme='dark'] .sheet-card-icon{background:#173f60;color:#f7d766;border-color:#45708e}
html[data-theme='dark'] .simulation-card,body.dark-mode .simulation-card{background:#10212b;border-color:#294957}
html[data-theme='dark'] .simulation-card p{color:#b8cdd6}
</style>

<section class="page-hero">
    <p class="eyebrow">Panduan, jobsheet &amp; simulasi praktikum</p>
    <h1>Praktikum</h1>
    <p>Ikuti panduan pelaksanaan di bawah ini terlebih dahulu, pilih topik jobsheet untuk menekan tombol mulai praktikum, atau gunakan simulasi sementara Heart Rate Smartwatch.</p>
    <div class="praktikum-jump">
        <a class="button outline" href="#panduan-praktikum">01. Panduan Praktikum</a>
        <a class="button outline" href="#jobsheet">02. Daftar Jobsheet</a>
        <a class="button outline" href="#simulasi-heart-rate">03. Simulasi Smartwatch</a>
    </div>
</section>

<section class="page-content">
    <section class="lecturer-section" id="panduan-praktikum" aria-labelledby="panduan-praktikum-heading" style="margin-top:0">
        <h2 id="panduan-praktikum-heading">Panduan Praktikum</h2>
        <p>Gunakan panduan ini sebelum membuka jobsheet agar kegiatan berjalan aman, terukur, dan terdokumentasi dengan baik.</p>
        <ol class="page-list">
            <li><span>01 · Sebelum</span><div><strong>Siapkan diri dan peralatan</strong><p>Pelajari tujuan modul, siapkan alat dan bahan, lalu pastikan area kerja serta perangkat dalam kondisi aman.</p></div></li>
            <li><span>02 · Saat</span><div><strong>Ikuti langkah kerja</strong><p>Rakit dan ukur sesuai jobsheet. Catat hasil pengamatan serta perubahan yang terjadi pada rangkaian atau sinyal.</p></div></li>
            <li><span>03 · Sesudah</span><div><strong>Dokumentasikan hasil</strong><p>Rapikan peralatan, analisis data yang diperoleh, lalu susun laporan praktikum sesuai ketentuan dosen pengampu.</p></div></li>
        </ol>
    </section>

    <section class="lecturer-section" id="jobsheet" aria-labelledby="jobsheet-catalog-heading">
        <h2 id="jobsheet-catalog-heading">Katalog Jobsheet</h2>
        <p>Pilih topik praktikum sesuai edisi panduan lalu klik <strong>Mulai Praktikum</strong> untuk membuka teori, K3, lembar pengamatan, dan latihan diskusi modul.</p>

        @forelse ($editions as $edition)
            <section class="sheet-edition" aria-labelledby="edition-{{ $loop->index }}">
                <h3 id="edition-{{ $loop->index }}">{{ $edition['title'] }} ({{ $edition['year'] }})</h3>
                <p class="sheet-meta">Penyusun: {{ $edition['author'] ?? 'Tidak dicantumkan' }} · {{ count($edition['modules']) }} topik</p>
                <div class="sheet-note">{{ $edition['status'] ?? 'Status validasi belum dicantumkan.' }}</div>

                @foreach (collect($edition['modules'])->groupBy('group') as $group => $modules)
                    <h3>{{ $group }}</h3>
                    <div class="sheet-grid">
                        @foreach ($modules as $module)
                            @php($visuals = ['∿', 'Ω', '⏚', '⌁', '◌', '⟲'])
                            <article class="sheet-card">
                                <div>
                                    <div class="sheet-card-head">
                                        <span class="sheet-card-icon" aria-hidden="true">{{ $visuals[($loop->iteration - 1) % count($visuals)] }}</span>
                                        <small>Jobsheet {{ $module['number'] ?? $loop->iteration }} · Halaman PDF {{ $module['pdf_page'] ?? '—' }}</small>
                                    </div>
                                    <strong>{{ $module['title'] }}</strong>
                                    <p>{{ $module['summary'] }}</p>
                                </div>
                                <a class="button primary sheet-card-cta" href="{{ route('jobsheet.module', ['edition' => $edition['id'], 'module' => $module['slug']]) }}">Mulai Praktikum <span>→</span></a>
                            </article>
                        @endforeach
                    </div>
                @endforeach
            </section>
        @empty
            <div class="ai-boundary"><strong>Belum ada edisi jobsheet.</strong> Tambahkan manifest JSON yang valid ke folder resources/jobsheets.</div>
        @endforelse
    </section>

    <section class="simulation-card" id="simulasi-heart-rate" aria-labelledby="simulasi-smartwatch-heading">
        <span class="simulation-badge">Simulasi Sementara · Candidate pilot</span>
        <h2 id="simulasi-smartwatch-heading">Praktikum Simulasi: Heart Rate Smartwatch (PPG)</h2>
        <p>Praktikum simulasi sementara menggunakan smartwatch atau mode simulasi Web Bluetooth (BLE) untuk mempelajari prinsip optik PPG, pembacaan detak jantung (BPM), pengamatan sinyal, dan refleksi sebelum perangkat praktikum fisik digunakan.</p>
        <div class="simulation-actions">
            <a class="button primary" href="{{ route('pilot.heart-rate') }}">Mulai Simulasi Heart Rate Smartwatch <span>→</span></a>
            <a class="button outline" href="{{ route('pilot.heart-rate') }}#pilot-jobsheet">Lihat Prosedur Simulasi</a>
        </div>
    </section>
</section>
</x-layouts.platform>
