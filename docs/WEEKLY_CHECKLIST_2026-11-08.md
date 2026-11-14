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
- [x] Setelah PR disetujui, pastikan GitHub Actions pada main hijau (CI sebelumnya sukses; cek lagi CI pada commit terbaru).
- [ ] Tetapkan maksimal 2-3 modul penelitian berdasarkan RPS/jobsheet resmi (shortlist teknis: PPG, AD620, LPF; belum disahkan).
- [ ] Pilih satu modul pilot. PPG/heart-rate boleh dipilih bila sesuai materi resmi.
- [ ] Lengkapi konten resmi modul pilot: tujuan, prasyarat, alat-bahan, keselamatan, langkah kerja, tabel data, interpretasi, refleksi, dan kriteria penilaian (seluruh komponen tersedia sebagai **draf**, perlu validasi dosen).
- [ ] Validasi dan lengkapi candidate pilot: materi -> pre-lab -> jobsheet -> praktikum/simulasi -> evaluasi -> interpretasi/refleksi -> laporan dengan konten resmi.
- [ ] Uji Monitor Trainer pada mode simulasi dan dokumentasikan hasil.
- [ ] Uji dan dokumentasikan BLE fisik (pengguna melaporkan Advan S2A berhasil melalui nRF Connect/Brave, 95/85 BPM pada sesi berbeda; OS, durasi, error dan bukti uji ulang Laravel terbaru belum lengkap). Lihat `docs/BLE_SMARTWATCH_TEST_LOG.md`.
- [ ] Jalankan kasus baseline AI pada dokumen AI_SCOPE (28 pertanyaan berbasis website sudah ditambahkan dan evaluator otomatis disiapkan; masih perlu eksekusi CI dan validasi pertanyaan terhadap materi resmi).
- [x] Susun **rancangan** peningkatan baseline retrieval menuju bounded RAG/LLM tanpa menghilangkan source grounding (`docs/BOUNDED_RAG_NEXT_STAGE.md`; belum implementasi LLM).
- [x] Tambahkan automated test untuk fungsi baru (fitur pilot dan evaluator; CI commit terbaru tetap harus diperiksa).
- [ ] Perbarui laporan mingguan dengan commit SHA, screenshot, hasil test, kendala, dan rencana minggu berikutnya.

## Status tambahan 14 November 2026

- Candidate pilot ditambah prasyarat, K3, rubrik draf 0–8, dan tabel tiga pengamatan yang dapat disimpan/ekspor secara lokal.
- Bukti konektivitas BLE historis Advan S2A didokumentasikan terpisah dari validasi akurasi dan uji ulang website versi terbaru.
- Korpus evaluasi baseline AI dibuat (28 kasus), disertai rubrik review manusia dan keluaran raw ke artifact GitHub Actions.
- Pengujian interaksi JavaScript dengan DOM mock di CI tidak menggantikan uji browser yang sebenarnya.
- Seluruh perubahan ini menunggu pengujian CI setelah commit.

## Bukti Minimum Akhir Minggu

1. main hijau setelah review/merge;
2. daftar 2-3 modul penelitian dan satu modul pilot;
3. satu alur pilot yang dapat ditelusuri dari awal sampai laporan;
4. bukti uji Monitor Trainer/simulasi dan, bila tersedia, BLE fisik;
5. tabel baseline AI 20-30 pertanyaan;
6. seluruh perubahan baru mempunyai test dan evidence commit.

## Yang Sengaja Belum Dikerjakan Dosen

Konten akademik resmi modul, keputusan final modul penelitian, validasi prosedur praktikum, pengujian hardware fisik, dan penilaian kualitas jawaban AI terhadap materi resmi tetap menjadi tanggung jawab mahasiswa bersama dosen pengampu.
