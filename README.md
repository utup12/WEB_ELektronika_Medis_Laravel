# Praktik Elektronika Medis — Platform Pembelajaran (Prototipe Sementara)

> **CATATAN PENTING UNTUK DOSEN PEMBIMBING / PENGAMPU**
>
> Website dan seluruh konten di repository ini **bersifat sementara (prototipe pengembangan awal)** untuk menguji arsitektur aplikasi, alur pembelajaran, koneksi Web Bluetooth (BLE), dan Asisten AI berbasis pencarian lokal.
>
> - Seluruh **jobsheet, materi, simulasi, kuis latihan, dan buku panduan** yang saat ini tampil di website **hanyalah bahan percobaan/referensi awal** (menggunakan arsip jobsheet lama 2019 dan draf simulasi), **bukan** materi resmi perkuliahan.
> - **Trainer kit fisik, jobsheet resmi, materi perkuliahan, RPS, serta buku panduan praktikum yang asli** saat ini masih dalam tahap menunggu dan baru akan tersedia serta diintegrasikan pada **Semester 2**.
> - Apabila perangkat fisik dan dokumen resmi Semester 2 sudah tersedia, seluruh konten, prosedur praktikum, rubrik penilaian, dan kalibrasi alat akan disesuaikan sepenuhnya mengikuti dokumen serta arahan dosen pengampu.

---

## Ringkasan Teknis Singkat

- **Framework:** Laravel 12 + Blade / Vite / TypeScript
- **Fokus Pengembangan Saat Ini:** Stabilitas CI, pemulihan release gate, alur pilot Heart Rate / PPG (mode simulasi & BLE `0x180D` / `0x2A37`), serta Asisten AI 100% lokal (tanpa API LLM eksternal).
- **Dokumen Terkait:**
    - [PROGRESS.md](PROGRESS.md) — Laporan progres mingguan dan status checklist CI.
    - [docs/PROJECT_ROADMAP.md](docs/PROJECT_ROADMAP.md) — Audit milestone (M0–M6) dan perbandingan kandidat modul.
    - [docs/PPG_PILOT_ACCEPTANCE_CHECKLIST.md](docs/PPG_PILOT_ACCEPTANCE_CHECKLIST.md) — Checklist uji browser manual pilot PPG.
    - [docs/BLE_SMARTWATCH_TEST_LOG.md](docs/BLE_SMARTWATCH_TEST_LOG.md) — Catatan uji BLE smartwatch & protokol uji ulang.

## Pemeriksaan Lokal (CI)

```bash
npm run check
npm run types:check
composer lint:check
composer types:check
php artisan test
```
