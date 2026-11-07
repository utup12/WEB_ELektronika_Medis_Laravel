# Roadmap Proyek dan Arah Tesis

## Tujuan

Platform Praktik Elektronika Medis dikembangkan sebagai media pembelajaran yang menghubungkan materi, jobsheet, praktikum, data trainer/sensor, evaluasi, refleksi, laporan, dan pemantauan dosen. Untuk arah tesis, fokus penelitian tidak boleh berhenti pada pembuatan aplikasi; harus ada mekanisme pembelajaran, akuisisi data, dan evaluasi empiris yang dapat diuji.

## Prinsip Scope

- Fokus penelitian dibatasi pada maksimal 2-3 modul praktikum.
- PPG/heart-rate menjadi kandidat utama modul biosignal karena prototipe Monitor Trainer sudah tersedia.
- Satu modul dipilih sebagai pilot end-to-end sebelum memperluas ke modul lain.
- AI berfungsi sebagai pendamping pembelajaran berbasis sumber yang dibatasi, bukan chatbot umum.
- Fitur tambahan yang tidak mendukung siklus pembelajaran inti tidak menjadi prioritas tesis.

## Siklus Pembelajaran Target

Pre-lab -> materi -> jobsheet -> praktikum/simulasi -> data sensor -> interpretasi -> scaffolding/feedback -> refleksi -> laporan -> dashboard dosen.

## Milestone

### M0 - Freeze Baseline dan Scope

Definition of Done:
- repository dan branch utama reproducible;
- baseline CI hijau;
- scope 2-3 modul disepakati;
- satu modul pilot ditetapkan;
- batas penggunaan AI didokumentasikan.

Status: IN PROGRESS. Baseline CI dan dokumentasi scope AI sudah disiapkan. Penetapan modul resmi tetap menunggu mahasiswa/dosen pengampu.

### M1 - Stable Application

Definition of Done:
- fresh clone dapat install, migrate, build, dan test;
- routing auth/settings/dashboard/invitation konsisten;
- test, TypeScript, Pint, PHPStan, dan CI lulus.

Status: READY FOR REVIEW melalui branch audit.

### M2 - Learning Core

Definition of Done:
- satu modul pilot memiliki alur materi -> pre-lab -> jobsheet -> praktikum -> evaluasi -> interpretasi/refleksi;
- tidak ada halaman buntu pada alur pilot;
- konten telah divalidasi oleh pihak yang berwenang.

Status: NOT STARTED secara end-to-end.

### M3 - PPG/Heart-Rate dan BLE

Definition of Done:
- mode simulasi terdokumentasi;
- perangkat fisik yang kompatibel diuji;
- data BPM dapat dibaca melalui BLE Heart Rate Service bila perangkat mendukung;
- hasil uji mencatat perangkat, browser, durasi, error, dan bukti;
- jika penyimpanan data menjadi bagian tesis, timestamp dan data pengukuran tersimpan serta dapat diekspor.

Status: EARLY PROTOTYPE. Mode simulasi tersedia; validasi hardware fisik belum menjadi bukti selesai.

### M4 - Assessment dan Scaffolding

Definition of Done:
- pretest/posttest atau evaluasi formatif tersedia untuk modul penelitian;
- feedback/hint dan interpretasi hasil dapat ditelusuri;
- data perkembangan mahasiswa dapat digunakan untuk evaluasi penelitian.

Status: NOT STARTED.

### M5 - Lecturer Dashboard dan Research Logging

Definition of Done:
- dosen dapat melihat aktivitas, hasil praktikum, evaluasi, interpretasi, dan laporan;
- event/log penelitian memiliki struktur yang terdokumentasi;
- dataset penelitian dapat diekspor tanpa data pribadi yang tidak diperlukan.

Status: NOT STARTED.

### M6 - Research Candidate dan Evaluasi Tesis

Definition of Done:
- versi penelitian dibekukan;
- instrumen dan prosedur uji ditetapkan;
- pilot study dijalankan;
- data efektivitas/usability/log dianalisis;
- hasil dapat digunakan untuk Bab IV-V dan artefak akhir tesis.

Status: NOT STARTED.

## Non-Goals Sementara

Hindari memperluas scope sekaligus ke banyak biosignal, banyak wearable, aplikasi mobile baru, predictive AI, atau chatbot internet umum sebelum M2-M3 stabil.
