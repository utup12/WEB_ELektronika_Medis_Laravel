<x-layouts.platform title="Laporan | Praktik Elektronika Medis">
<section class="page-hero">
    <p class="eyebrow">Pengumpulan laporan</p>
    <h1>Unggah Laporan Praktikum</h1>
    <p>PDF maksimum 10 MB. Laporan akan masuk ke antrean koreksi dosen.</p>
</section>
<section class="page-content">
    <div class="learning-grid">
        <form
            class="learning-panel"
            action="{{ route('laporan.store') }}"
            method="POST"
            enctype="multipart/form-data"
            data-r2-upload-form
            data-r2-enabled="{{ ($r2Configured ?? false) ? '1' : '0' }}"
            data-presign-url="{{ route('laporan.presign') }}"
            data-store-url="{{ route('laporan.store') }}"
        >
            @csrf
            <h2>Kirim laporan</h2>
            @if ($r2Configured ?? false)
                <p class="notice success">Penyimpanan objek <strong>Cloudflare R2</strong> aktif — PDF diunggah langsung ke R2 (aman hingga 10 MB).</p>
            @else
                <p class="notice">Mode penyimpanan lokal aktif. Di production Vercel, aktifkan variabel <code>R2_*</code> agar berkas PDF tersimpan permanen di Cloudflare R2.</p>
            @endif
            @if(session('success'))
                <p class="notice success">{{ session('success') }}</p>
            @endif
            <p data-r2-status role="status" aria-live="polite" hidden></p>
            <label>Modul praktikum
                <select name="module" required>
                    <option value="">Pilih modul</option>
                    @for($i = 1; $i <= 14; $i++)
                        <option value="Jobsheet {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}">Jobsheet {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                    <option value="Simulasi Heart Rate Smartwatch">Simulasi Heart Rate Smartwatch (PPG)</option>
                </select>
            </label>
            <label>Berkas PDF
                <input type="file" name="report" accept="application/pdf" required>
            </label>
            @error('report')
                <p class="notice error">{{ $message }}</p>
            @enderror
            <button class="button primary" type="submit">Kirim Laporan <span>→</span></button>
        </form>
        <aside class="learning-panel">
            <h2>Ketentuan</h2>
            <ol>
                <li>Gunakan format PDF (Maksimum 10 MB).</li>
                <li>Sertakan identitas mahasiswa, data pengukuran, analisis teknis, dan kesimpulan.</li>
                <li>Periksa status dan umpan balik pada daftar riwayat.</li>
            </ol>
        </aside>
    </div>

    <section class="lecturer-section">
        <h2>Riwayat laporan saya</h2>
        <table class="review-table">
            <thead>
                <tr><th>Modul</th><th>Berkas</th><th>Status</th><th>Nilai</th><th>Umpan balik</th></tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->module }}</td>
                        <td><a href="{{ route('laporan.download', $report) }}" target="_blank">{{ $report->original_name }}</a></td>
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
<script defer src="{{ asset('js/report-upload-r2.js') }}"></script>
</x-layouts.platform>
