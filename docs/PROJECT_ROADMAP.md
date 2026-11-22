# Roadmap Proyek dan Arah Tesis

## Tujuan

Platform Praktik Elektronika Medis dikembangkan sebagai media pembelajaran yang menghubungkan materi, jobsheet, praktikum, data trainer/sensor, evaluasi, refleksi, laporan, dan pemantauan dosen. Untuk arah tesis, fokus penelitian tidak boleh berhenti pada pembuatan aplikasi; harus ada mekanisme pembelajaran, akuisisi data, dan evaluasi empiris yang dapat diuji.

## Prinsip Scope

- Fokus penelitian dibatasi pada **1 modul pilot utama** dan maksimal **2 modul pendamping/pembanding**.
- AI berfungsi sebagai pendamping pembelajaran berbasis sumber lokal yang dibatasi (_local grounded retrieval_ + kalkulator deterministik), bukan chatbot umum atau LLM eksternal.
- Fitur tambahan di luar siklus pembelajaran inti penelitian ditandai sebagai **non-blocking** untuk tesis.

## Perbandingan Kandidat Modul & Keputusan Scope Sementara

| Aspek Penilaian                 | Heart Rate / PPG (Kandidat Pilot Utama)                                        | Penguat Instrumentasi AD620 (Pendamping 1)                      | Low Pass Filter Orde Pertama (Pendamping 2)                     |
| ------------------------------- | ------------------------------------------------------------------------------ | --------------------------------------------------------------- | --------------------------------------------------------------- |
| Kesesuaian RPS / CPMK           | Tinggi untuk topik akuisisi biosignal & pemantauan optik                       | Tinggi untuk pengondisian sinyal awal (Jobsheet 02, 2019)       | Tinggi untuk penyaringan sinyal analog (Jobsheet 04, 2019)      |
| Kesiapan Hardware               | Prototipe smartwatch BLE (Advan S2A) + mode simulasi tersedia                  | Membutuhkan modul trainer kit / rangkaian fisik IC AD620 di lab | Membutuhkan modul trainer kit / rangkaian RC aktif di lab       |
| Kesiapan Data & Media           | Alur pilot lengkap + ekspor CSV/TXT + log BLE awal                             | Kalkulator RG deterministik + tabel observasi digital tersedia  | Tabel pengamatan + grafik respons frekuensi interaktif tersedia |
| Risiko K3                       | Rendah (wearable non-invasif + mode simulasi); tidak untuk diagnosis medis     | Sedang (catu daya ±12 V & koneksi lab perlu SOP K3 dosen)       | Sedang (catu daya & generator sinyal lab perlu SOP K3 dosen)    |
| Kesiapan Instrumen Evaluasi     | Pre-lab, rubrik formatif 0–8, interpretasi, refleksi (menunggu validasi dosen) | Soal latihan & kuis dasar tersedia di halaman jobsheet          | Soal latihan & kuis dasar tersedia di halaman jobsheet          |
| Kontribusi Penelitian           | Alur pembelajaran end-to-end berbasis web + akuisisi data BLE/simulasi         | Pembanding kesiapan modul pengondisian sinyal analog            | Pembanding kesiapan modul filtering sinyal analog               |
| Kebutuhan Pengembangan Tambahan | Uji browser manual & uji ulang BLE pada versi Laravel terbaru                  | Penyelarasan edisi RPS terbaru & validasi hardware              | Penyelarasan edisi RPS terbaru & validasi hardware              |

**Keputusan Scope Sementara (menunggu pengesahan RPS & dosen pengampu):**

1. **Modul Pilot Utama:** **Heart Rate / PPG** (alur end-to-end `/materi` → `/evaluasi` → `/pilot/heart-rate` → `/monitor-trainer` → `/laporan`).
2. **Modul Pendamping / Pembanding (maksimal 2):** **Penguat Instrumentasi AD620** dan **Low Pass Filter Orde Pertama**.
3. Penambahan modul baru dihentikan sampai scope ini disahkan oleh dosen pengampu.

## Siklus Pembelajaran Target

Pre-lab -> materi -> jobsheet -> praktikum/simulasi -> data sensor -> interpretasi -> scaffolding/feedback -> refleksi -> laporan -> dashboard dosen.

## Audit & Status Milestone (M0–M6)

Keterangan dimensi kesiapan:

- **Implemented**: Fitur & kode sudah ada di repository.
- **Tested**: Teruji otomatis (PHPUnit/Pest, PHPStan, Pint, `vp check`, `tsc`, DOM mock).
- **Browser-validated**: Teruji manual end-to-end di browser nyata sesuai checklist.
- **Academically validated**: Disetujui dosen pengampu (RPS, CPMK, K3, rubrik).
- **Research-ready**: Siap digunakan sebagai instrumen pengumpulan data tesis.

### M0 - Freeze Baseline dan Scope

- **Implemented:** Ya (dokumentasi scope AI, perbandingan kandidat modul, kebijakan rilis).
- **Tested:** Ya (CI check lokal hijau).
- **Browser-validated:** Sebagian (menunggu checklist browser lengkap).
- **Academically validated:** Belum (menunggu pengesahan RPS & modul final dari dosen).
- **Research-ready:** Belum.
- **Status:** `IN PROGRESS`.

### M1 - Stable Application

- **Implemented:** Ya (autentikasi lokal `/masuk` & `/daftar`, manajemen role mahasiswa/dosen, keamanan OWASP, private report storage, rate limiter, security headers).
- **Tested:** Ya (`vp check`, `tsc --noEmit`, `pint`, `phpstan`, `php artisan test`, `SecurityHardeningTest`).
- **Browser-validated:** Sebagian.
- **Academically validated:** N/A (infrastruktur teknis).
- **Research-ready:** Menunggu CI hijau di `main`.
- **Status:** `READY FOR REVIEW`.

### M2 - Learning Core

- **Implemented:** Ya (materi, pre-lab, 14 jobsheet katalog 2019, simulasi pilot PPG, observasi digital, interpretasi, refleksi, ekspor lokal).
- **Tested:** Ya (`HeartRatePilotFlowTest`, `JobsheetCatalogTest`, `scripts/test_pilot_client.mjs`).
- **Browser-validated:** Belum (`docs/PPG_PILOT_ACCEPTANCE_CHECKLIST.md` perlu dijalankan manual).
- **Academically validated:** Belum (menunggu review konten & rubrik oleh dosen).
- **Research-ready:** Belum.
- **Status:** `IMPLEMENTED (DRAFT) — AWAITING BROWSER & ACADEMIC VALIDATION`.

### M3 - PPG/Heart-Rate dan BLE

- **Implemented:** Ya (`/monitor-trainer` mendukung mode SIMULASI, BLE WAIT, BLE LIVE untuk Heart Rate Service `0x180D` / `0x2A37`).
- **Tested:** Sebagian (uji historis Advan S2A tercatat di `docs/BLE_SMARTWATCH_TEST_LOG.md`, uji otomatis alur halaman lulus).
- **Browser-validated:** Belum pada commit Laravel terbaru (perlu uji ulang dengan metadata OS, browser, durasi, >= 3 sampel BPM, disconnect/reconnect).
- **Academically validated:** Belum (kalibrasi/perbandingan alat rujukan belum dilakukan).
- **Research-ready:** Belum.
- **Status:** `PROTOTYPE — REQUIRES RE-TEST ON LATEST BUILD`.

### M4 - Assessment dan Scaffolding

- **Implemented:** Ya (evaluasi pre-lab `QuizAttemptController`, umpan balik lokal, Asisten AI lokal dengan memori per pengguna + batas 10 percakapan + reset, evaluator 28 kasus).
- **Tested:** Ya (`AiAssistantControllerTest`, `AiAssistantBaselineTest`, `AiAssistantMemoryTest`, `evaluate_ai_baseline.php`).
- **Browser-validated:** Sebagian.
- **Academically validated:** Belum (rubrik formatif 0–8 dan 28 kasus AI menunggu penilaian manual 6 dimensi oleh dosen/peneliti).
- **Research-ready:** Belum.
- **Status:** `IMPLEMENTED (DRAFT) — AWAITING HUMAN EVALUATION`.

### M5 - Lecturer Dashboard dan Research Logging

- **Implemented:** Ya. Repository telah memiliki `LecturerDashboardController`, `LecturerManagementController`, `StudentAttendanceController`, `StudentProgressController`, `ReportController`, serta model `ModuleProgress`, `QuizAttempt`, dan `Report` untuk memantau progres, presensi, kuis, dan unggahan laporan PDF privat mahasiswa.
- **Tested:** Ya (`SecurityHardeningTest` mencakup proteksi IDOR dosen/mahasiswa, rate limiting, private disk, dan akses role).
- **Browser-validated:** Belum (perlu uji alur peran dosen & mahasiswa di browser nyata).
- **Academically validated:** Belum (format ekspor dataset penelitian tanpa PII masih perlu disepakati).
- **Research-ready:** Belum (ekspor dataset penelitian terstruktur masih perlu disempurnakan bila diperlukan tesis).
- **Status:** `IMPLEMENTED (CORE DASHBOARD & TRACKING) — NON-BLOCKING FEATURES FROZEN`.

### M6 - Research Candidate dan Evaluasi Tesis

- **Implemented:** Belum.
- **Tested:** Belum.
- **Browser-validated:** Belum.
- **Academically validated:** Belum.
- **Research-ready:** Belum.
- **Status:** `NOT STARTED`.

## Fitur Non-Blocking (Ditandai Beku Sementara)

Fitur berikut sudah ada atau bersifat pendukung dan **tidak menghalangi** fokus uji pilot PPG untuk tesis:

- Manajemen Team/Workspace bawaan starter kit (`TeamController`, `TeamInvitationController`).
- Penambahan modul jobsheet baru di luar 1 modul pilot (PPG) dan 2 modul pembanding (AD620, LPF).
- Integrasi LLM/RAG eksternal berbasis API berbayar (masih berstatus rancangan di `docs/BOUNDED_RAG_NEXT_STAGE.md`).
