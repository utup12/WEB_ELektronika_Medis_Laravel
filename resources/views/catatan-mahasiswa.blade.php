<x-layouts.platform title="Catatan Mahasiswa | Praktik Elektronika Medis">
<link rel="stylesheet" href="{{ asset('css/paper-notes.css') }}">
<link rel="stylesheet" href="{{ asset('css/paper-tools.css') }}">
<section class="page-hero">
    <p class="eyebrow">Ruang belajar pribadi</p>
    <h1>Catatan Mahasiswa</h1>
    <p>Kanvas catatan bergaya kertas untuk menulis langsung seperti Word, menggambar, dan merangkum materi dosen.</p>
</section>
<section class="page-content">
    <div class="paper-toolbar">
        <button type="button" data-note-prev title="Halaman sebelumnya">←</button>
        <strong data-note-label>Halaman 1 / 10</strong>
        <button type="button" data-note-next title="Halaman berikutnya">→</button>
        <span></span>
        <button type="button" data-note-pen class="is-active" title="Pena">✒</button>
        <label class="tool-size">Pena <input data-pen-size type="range" min="1" max="18" value="4"></label>
        <button type="button" data-note-eraser title="Penghapus">⌫</button>
        <label class="tool-size">Hapus <input data-eraser-size type="range" min="8" max="80" value="34"></label>
        <button type="button" data-note-text title="Mode Teks (ketik langsung di kertas)">T</button>
        <button type="button" data-note-undo title="Undo (Ctrl+Z)">↶</button>
        <button type="button" data-note-redo title="Redo (Ctrl+Y)">↷</button>
        <button type="button" data-note-clear title="Hapus halaman">🗑</button>
        <button type="button" data-note-new class="paper-new">+ Halaman baru</button>
    </div>
    <p class="paper-instruction">Mode Teks (<b>T</b>): klik di mana saja pada kertas lalu langsung ketik seperti Microsoft Word (klik luar atau tekan <b>Esc</b> untuk menyimpan ke kertas).</p>
    <div class="paper-stage">
        <div class="paper-sheet">
            <canvas data-note-canvas data-tool="pen" width="1180" height="760"></canvas>
            <p class="paper-hint" data-note-hint>Mode pena aktif. Pilih T untuk mengetik langsung di kertas.</p>
        </div>
    </div>
</section>
<script src="{{ asset('js/student-notes.js') }}"></script>
</x-layouts.platform>
