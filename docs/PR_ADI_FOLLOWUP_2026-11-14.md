# Tindak lanjut permintaan Pak Adi — PR #2

**Rujukan:** `https://github.com/utup12/WEB_ELektronika_Medis_Laravel/pull/2` (merged 8 November 2026). Dokumen ini membedakan **implementasi kode**, **laporan uji pengguna**, dan **validasi akademik**.

## Tiga kandidat modul untuk dikaji, bukan keputusan resmi

| Kandidat | Alasan teknis | Kesenjangan sebelum dipilih |
| --- | --- | --- |
| Heart Rate / PPG | Monitor simulasi dan konektivitas BLE smartwatch telah dilaporkan berhasil; berpeluang untuk alur biosignal | Kesesuaian RPS/CPMK, K3, proses kalibrasi/ketidakpastian, dan jobsheet resmi |
| Penguat instrumentasi AD620 | Perhitungan gain/RG dan tabel observasi digital sudah ada dari Jobsheet 2019 | Penyelarasan materi edisi terbaru, rangkaian fisik, prosedur dan validasi praktikum |
| Low Pass Filter orde pertama | Tabel pengamatan, grafik frekuensi, ekspor dan pemeriksaan data telah tersedia | Konfirmasi cakupan mata kuliah, capaian praktikum, dan evaluasi dosen |

**Rekomendasi teknis sementara:** lanjutkan Heart Rate / PPG sebagai satu candidate pilot end-to-end dan gunakan AD620 serta LPF sebagai pembanding kesiapan. **Belum ada keputusan final 2–3 modul tesis** sampai dokumen RPS/jobsheet resmi serta persetujuan dosen tersedia.

## Matriks tindak lanjut

| Target PR #2 | Bukti saat ini | Status |
| --- | --- | --- |
| Baseline Laravel & CI | Pengujian GitHub Actions pada main | Terimplementasi; periksa commit terbaru |
| Roadmap dan scope AI | `docs/PROJECT_ROADMAP.md`, `docs/AI_SCOPE.md` | Terdokumentasi |
| Candidate pilot lengkap | Materi, pre-lab, jobsheet, simulasi, tabel input, rubrik draf, refleksi dan ekspor TXT | Implementasi draf, perlu uji browser dan validasi |
| BLE fisik | `docs/BLE_SMARTWATCH_TEST_LOG.md` — Advan S2A, 0x180D, 0x2A37, BPM yang dilaporkan | **Konektivitas dilaporkan berhasil**, uji ulang Laravel terbaru & detail bukti belum lengkap |
| Evaluasi AI 20–30 pertanyaan | `resources/ai-evaluation/baseline-cases.json` dan script evaluator | 28 kasus disiapkan; eksekusi otomatis dan review manusia dipisah |
| Rubrik AI groundedness/fallback | `docs/AI_BASELINE_EVALUATION_PROTOCOL.md` | Instrumen siap direview; belum menjadi hasil validasi manusia |
| Peta bounded RAG/LLM | `docs/BOUNDED_RAG_NEXT_STAGE.md` | Arsitektur usulan, belum diimplementasikan |
| Uji otomatis fitur baru | Feature tests dan langkah CI evaluasi | Pemeriksaan otomatis, bukan pengganti uji manual |
| Evidence mingguan | Dokumen ini, riwayat commit, CI, checklist | Screenshot browser, log BLE lengkap, tanda tangan validasi dosen masih dibutuhkan |

## Pemeriksaan akhir sebelum meminta review dosen

- [ ] Lampirkan RPS/jobsheet resmi, cocokkan CPMK dan putuskan modul final.
- [ ] Lakukan uji browser alur pilot (kuis, tabel, draf, ekspor) di URL yang tepat.
- [ ] Lampirkan screenshot uji ulang BLE pada Laravel terbaru dan isi durasi/browser/OS/error.
- [ ] Isi penilaian manusia untuk 28 respons AI yang dihasilkan dari GitHub Actions.
- [ ] Minta dosen meninjau isi, rubrik, batasan K3, dan status pelaksanaan pilot.
- [ ] Dokumentasikan semua perubahan dengan SHA dan tautan hasil CI terbaru.

## Aturan rilis

Hanya commit ke `main`; jangan mengubah `deployment/vercel` dan jangan deploy Vercel sebelum izin eksplisit pengguna.
