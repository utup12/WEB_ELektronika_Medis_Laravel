# Progress Report — Praktik Elektronika Medis (Laravel)

> **Catatan Konteks untuk Dosen:** Website, jobsheet, materi, dan simulasi yang ada saat ini **bersifat sementara (prototipe percobaan)** sambil menunggu **trainer kit fisik, jobsheet resmi, materi, RPS, dan buku panduan praktikum asli yang akan digunakan pada Semester 2**.

Dokumen ini merangkum progres pengembangan dan pemulihan release gate berdasarkan **GitHub Issue #10 (Target 19–25 Nov 2026 — CI Recovery, Pilot Validation, Thesis Scope Freeze)**.

## Status P0 — Pemulihan CI & Kualitas Kode

- [x] `npm run check:fix` (`vp check --fix`) dijalankan pada 15 file yang sebelumnya gagal formatting di CI.
- [x] `npm run check` (`vp check`) lulus tanpa error formatting maupun lint pada 122 file.
- [x] Perbaikan deklarasi Wayfinder (`LocalAuthController::showLogin` & `showRegister`) sehingga `npm run types:check` (`tsc --noEmit`) lulus 0 error.
- [x] Perbaikan tipe generik & array offset PHPStan pada model dan controller (`AiAssistantController`, `LecturerManagementController`, `QuizAttemptController`, `ModuleProgress`, `QuizAttempt`, `Report`, `User`) sehingga `composer types:check` lulus 0 error.
- [x] `composer lint:check` (`pint --parallel --test`) lulus.
- [x] Seluruh `php artisan test` diselaraskan dan lulus, termasuk test fitur AI memory, security hardening, pilot PPG, dan jobsheet.
- [x] `node scripts/test_pilot_client.mjs` dan `php scripts/evaluate_ai_baseline.php` (28 kasus) terverifikasi berjalan lokal.
- [ ] Menunggu review pengguna pada branch `deployment/vercel` sebelum sinkronisasi ke `main` dan verifikasi run GitHub Actions `tests` hijau di `main`.

## Status P0 — Freeze Scope Penelitian / Tesis

- [x] Tabel perbandingan kandidat **PPG vs Penguat Instrumentasi AD620 vs Low Pass Filter Orde Pertama** ditambahkan ke `docs/PROJECT_ROADMAP.md`.
- [x] Rekomendasi sementara: **1 modul pilot utama (Heart Rate / PPG)** dan **2 modul pendamping/pembanding (AD620 & LPF Orde Pertama)**.
- [ ] Menunggu lampiran RPS/jobsheet resmi terbaru dan pengesahan akhir dari dosen pengampu.

## Status P1 — Pilot Heart Rate / PPG, BLE, & Evaluasi AI

- [x] Uji otomatis `HeartRatePilotFlowTest` dan headless DOM mock `scripts/test_pilot_client.mjs` lulus.
- [x] Evaluasi otomatis 28 kasus AI (`scripts/evaluate_ai_baseline.php`) menghasilkan keluaran CSV/JSON lokal (`24/28` source/fallback match, `21/28` text indicator).
- [ ] **Uji browser manual** (`docs/PPG_PILOT_ACCEPTANCE_CHECKLIST.md`) belum boleh diklaim lulus sebelum dilakukan langsung di browser oleh penguji.
- [ ] **Uji ulang BLE fisik** pada commit Laravel terbaru (Advan S2A / perangkat kompatibel, mencatat OS, browser, durasi, 3 sampel BPM + timestamp, disconnect/reconnect, serta screenshot/log aman) sesuai `docs/BLE_SMARTWATCH_TEST_LOG.md`.
- [ ] **Review manusia 6 dimensi** terhadap hasil 28 kasus AI sesuai `docs/AI_BASELINE_EVALUATION_PROTOCOL.md`.

## Status P1 & P2 — Rekonsiliasi Roadmap, Stabilitas, & Disiplin Rilis

- [x] `docs/PROJECT_ROADMAP.md` direkonsiliasi (M0–M6) dengan status aktual kode, termasuk pembaruan **M5 (Lecturer Dashboard dan Research Logging)**.
- [x] Fitur dosen/mahasiswa kritis memiliki cakupan test keamanan (`SecurityHardeningTest`) untuk IDOR, rate limit, private report storage, dan security headers.
- [x] Kebijakan branch: `main` sebagai _source of truth_ pengembangan; `deployment/vercel` disiapkan sebagai target rilis terkendali setelah persetujuan pengguna.
