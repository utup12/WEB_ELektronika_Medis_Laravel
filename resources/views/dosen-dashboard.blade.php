<x-layouts.platform title="Dashboard Dosen | Praktik Elektronika Medis">
<section class="page-hero">
    <p class="eyebrow">Ruang kerja pengajar</p>
    <h1>Dashboard Dosen</h1>
    <p>Manajemen kelas, presensi, folder pengumpulan Google Drive, penilaian, dan perangkat praktikum.</p>
</section>
<section class="page-content">
    <div class="lecturer-actions">
        <a class="button primary" href="{{ route('dosen.classes') }}">Kelas &amp; Kelompok</a>
        <a class="button primary" href="{{ route('dosen.attendance') }}">Kalender Presensi</a>
        <a class="button primary" href="{{ route('dosen.announcements') }}">Pengumuman</a>
        <a class="button primary" href="{{ route('dosen.monitoring') }}">Monitoring</a>
        <a class="button primary" href="{{ route('dosen.trainer') }}">Trainer Kit</a>
        <a class="button primary" href="{{ route('dosen.questions') }}">Bank Soal</a>
    </div>

    <div class="lecturer-summary" style="margin-top:24px">
        <article class="summary-card"><span>Mahasiswa aktif</span><strong>{{ $studentCount }}</strong></article>
        <article class="summary-card"><span>Menunggu koreksi</span><strong>{{ $pendingReports }}</strong></article>
        <article class="summary-card"><span>Pre-lab tersimpan</span><strong>{{ $attemptCount }}</strong></article>
    </div>

    <section class="lecturer-section" aria-labelledby="drive-settings-heading">
        <h2 id="drive-settings-heading">Folder Google Drive Pengumpulan Laporan</h2>
        <p>Pasang tautan folder Google Drive tujuan agar muncul di halaman Unggah Laporan mahasiswa.</p>
        @if(session('success'))
            <p class="notice success">{{ session('success') }}</p>
        @endif
        <form class="learning-panel" action="{{ route('dosen.drive.update') }}" method="POST">
            @csrf
            <label>Tautan Folder Google Drive Tujuan
                <input type="url" name="drive_folder_url" placeholder="https://drive.google.com/drive/folders/..." value="{{ old('drive_folder_url', $driveFolderUrl) }}">
            </label>
            @error('drive_folder_url')
                <p class="notice error">{{ $message }}</p>
            @enderror
            <label>Catatan / Format Penamaan untuk Mahasiswa (opsional)
                <textarea name="drive_note" rows="2" maxlength="500" placeholder="Contoh: Unggah PDF dengan format NIM_Nama_JobsheetXX.pdf lalu tempel link Drive Anda.">{{ old('drive_note', $driveNote) }}</textarea>
            </label>
            <button class="button primary" type="submit">Simpan Tautan Google Drive <span>→</span></button>
        </form>
    </section>

    <section class="lecturer-section">
        <h2>Antrean Koreksi Laporan</h2>
        <table class="review-table">
            <thead>
                <tr><th>Mahasiswa</th><th>Modul</th><th>Berkas / Drive</th><th>Koreksi</th></tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->module }}</td>
                        <td><a target="_blank" rel="noopener" href="{{ route('laporan.download', $report) }}">Buka Laporan ↗</a></td>
                        <td>
                            <form action="{{ route('dosen.reports.grade', $report) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status">
                                    <option value="revision">Perlu revisi</option>
                                    <option value="graded">Dinilai</option>
                                </select>
                                <input name="score" type="number" min="0" max="100" placeholder="Nilai">
                                <textarea name="feedback" placeholder="Umpan balik"></textarea>
                                <button class="button text-button">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada laporan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</section>
</x-layouts.platform>
