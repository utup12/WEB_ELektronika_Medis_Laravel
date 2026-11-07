# Checklist Mingguan 8-14 November 2026

## Target Minggu

Menutup baseline teknis, menetapkan scope penelitian, memulai satu modul pilot end-to-end, dan membangun baseline evaluasi AI sebelum pengembangan LLM/RAG.

## Sudah Dibantu Dikerjakan

- [x] Audit baseline repository dan pemulihan pipeline CI.
- [x] Registrasi route Laravel/Inertia untuk settings, dashboard, dan invitation workflow.
- [x] Penambahan migration kolom 2FA yang dibutuhkan factory/model.
- [x] Normalisasi formatting dan konfigurasi memory PHPStan untuk CI.
- [x] Dokumentasi roadmap proyek sampai arah tesis.
- [x] Dokumentasi batas/scope AI.
- [x] Baseline test otomatis AI untuk source-grounding, BLE/Monitor Trainer, laporan, dan fallback.
- [x] Monitor Trainer ditambahkan sebagai sumber pengetahuan resmi untuk baseline assistant.
- [x] Kerangka candidate pilot Heart Rate/PPG dibuat sebagai hub end-to-end dengan automated test.

## Harus Dilanjutkan Mahasiswa Minggu Ini

- [ ] Review PR dosen per commit; beri komentar bila ada perubahan yang tidak dipahami atau tidak disetujui.
- [ ] Setelah PR disetujui, pastikan GitHub Actions pada main hijau.
- [ ] Tetapkan maksimal 2-3 modul penelitian berdasarkan RPS/jobsheet resmi.
- [ ] Pilih satu modul pilot. PPG/heart-rate boleh dipilih bila sesuai materi resmi.
- [ ] Lengkapi konten resmi modul pilot: tujuan, prasyarat, alat-bahan, keselamatan, langkah kerja, tabel data, interpretasi, refleksi, dan kriteria penilaian.
- [ ] Validasi dan lengkapi candidate pilot: materi -> pre-lab -> jobsheet -> praktikum/simulasi -> evaluasi -> interpretasi/refleksi -> laporan dengan konten resmi.
- [ ] Uji Monitor Trainer pada mode simulasi dan dokumentasikan hasil.
- [ ] Jika hardware tersedia, uji BLE pada perangkat fisik yang kompatibel. Catat nama perangkat, browser, OS, durasi, keberhasilan koneksi, BPM, dan error.
- [ ] Jalankan kasus baseline AI pada dokumen AI_SCOPE dan tambahkan minimal 20-30 pertanyaan evaluasi yang mewakili materi resmi.
- [ ] Susun desain peningkatan baseline retrieval menuju bounded RAG/LLM tanpa menghilangkan source grounding.
- [ ] Tambahkan automated test untuk setiap fungsi baru.
- [ ] Perbarui laporan mingguan dengan commit SHA, screenshot, hasil test, kendala, dan rencana minggu berikutnya.

## Bukti Minimum Akhir Minggu

1. main hijau setelah review/merge;
2. daftar 2-3 modul penelitian dan satu modul pilot;
3. satu alur pilot yang dapat ditelusuri dari awal sampai laporan;
4. bukti uji Monitor Trainer/simulasi dan, bila tersedia, BLE fisik;
5. tabel baseline AI 20-30 pertanyaan;
6. seluruh perubahan baru mempunyai test dan evidence commit.

## Yang Sengaja Belum Dikerjakan Dosen

Konten akademik resmi modul, keputusan final modul penelitian, validasi prosedur praktikum, pengujian hardware fisik, dan penilaian kualitas jawaban AI terhadap materi resmi tetap menjadi tanggung jawab mahasiswa bersama dosen pengampu.
