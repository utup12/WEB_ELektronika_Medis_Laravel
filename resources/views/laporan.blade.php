<x-layouts.platform title="Laporan | Praktik Elektronika Medis">
<section class="page-hero">
    <p class="eyebrow">Pengumpulan laporan</p>
    <h1>Unggah Laporan Praktikum</h1>
    <p>Unggah PDF (Maksimum 10 MB) ke folder Google Drive dosen lalu kirim tautannya di sini agar masuk ke antrean koreksi dosen.</p>
</section>

<section class="page-content">
    <section class="ai-boundary" style="margin-bottom:24px" aria-labelledby="drive-target-heading">
        <strong id="drive-target-heading">Folder Google Drive Pengumpulan Laporan</strong>
        <p>{{ $driveNote }}</p>
        @if(!empty($driveFolderUrl))
            <p style="margin-top:12px">
                <a class="button primary" href="{{ $driveFolderUrl }}" target="_blank" rel="noopener">Buka Folder Google Drive Dosen <span>↗</span></a>
            </p>
        @else
            <p style="margin-top:8px;color:#6b5216">Tautan folder Google Drive belum diatur oleh dosen pengampu. Silakan hubungi dosen untuk mendapatkan tautan folder pengumpulan.</p>
        @endif
    </section>

    <div class="learning-grid">
        <div style="display:grid;gap:20px">
            <form class="learning-panel" action="{{ route('laporan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="confirm_drive" value="1">
                <h2>Catat Pengumpulan ke Google Drive Dosen</h2>
                <p style="margin:0;color:var(--muted);font-size:.9rem">Unggah file PDF Anda ke folder Google Drive dosen di atas terlebih dahulu, lalu catat modul dan nama berkasnya di bawah ini agar masuk ke antrean koreksi dosen.</p>
                @if(session('success'))
                    <p class="notice success">{{ session('success') }}</p>
                @endif
                @error('confirm_drive')
                    <p class="notice error">{{ $message }}</p>
                @enderror
                <label>Modul praktikum
                    <select name="module" required>
                        <option value="">Pilih modul</option>
                        @for($i = 1; $i <= 14; $i++)
                            <option value="Jobsheet {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}">Jobsheet {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}</option>
                        @endfor
                        <option value="Simulasi Heart Rate Smartwatch">Simulasi Heart Rate Smartwatch (PPG)</option>
                    </select>
                </label>
                <label>Nama berkas / catatan singkat
                    <input type="text" name="report_title" placeholder="Contoh: NIM_Nama_Jobsheet01.pdf" value="{{ old('report_title') }}" maxlength="180" required>
                </label>
                @error('report_title')
                    <p class="notice error">{{ $message }}</p>
                @enderror
                <button class="button primary" type="submit" @disabled(empty($driveFolderUrl))>Catat Pengumpulan Laporan <span>→</span></button>
            </form>
        </div>

        <aside class="learning-panel" style="align-self:start">
            <h2>Ketentuan</h2>
            <ol>
                <li>Gunakan format PDF (Maksimum 10 MB).</li>
                <li>Sertakan identitas mahasiswa, data pengukuran, analisis teknis, dan kesimpulan.</li>
                <li>Beri nama file: <code>NIM_Nama_JobsheetXX.pdf</code>.</li>
                <li>Periksa status dan umpan balik dosen pada daftar riwayat di bawah.</li>
            </ol>
        </aside>
    </div>

    <section class="lecturer-section">
        <h2>Riwayat laporan saya</h2>
        <table class="review-table">
            <thead>
                <tr><th>Modul</th><th>Berkas / Tautan</th><th>Status</th><th>Nilai</th><th>Umpan balik</th></tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->module }}</td>
                        <td><a href="{{ route('laporan.download', $report) }}" target="_blank" rel="noopener">{{ $report->original_name }}</a></td>
                        <td><span class="review-status {{ $report->status }}">{{ $report->status }}</span></td>
                        <td>{{ $report->score ?? '—' }}</td>
                        <td>{{ $report->feedback ?? 'Belum ada.' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada laporan yang dikirim.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</section>
</x-layouts.platform>
