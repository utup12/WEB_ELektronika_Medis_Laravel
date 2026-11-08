# Scope AI dan Baseline Evaluasi

## Status Saat Ini

Asisten saat ini adalah baseline retrieval berbasis konten halaman Laravel. Sistem belum menggunakan LLM atau RAG generatif. Jawaban diambil dari sumber pembelajaran lokal, diberi skor berdasarkan istilah pertanyaan, lalu mengembalikan potongan sumber yang paling relevan.

Baseline ini dipertahankan sebagai pembanding sebelum pengembangan bounded RAG/LLM.

## Sumber Pengetahuan yang Diizinkan

- Beranda
- Materi Praktikum
- Jobsheet Praktikum
- Panduan Praktikum
- Praktikum
- Monitor Trainer
- Evaluasi Praktikum
- Unggah Laporan

Konten di luar sumber tersebut tidak boleh dianggap sebagai fakta oleh baseline assistant.

## Perilaku yang Diharapkan

- menjawab hanya bila ada dukungan pada sumber pembelajaran;
- menyertakan sumber yang relevan;
- memberikan fallback bila informasi tidak ditemukan;
- tidak membuat klaim klinis atau diagnosis;
- tidak mengklaim hardware telah tervalidasi tanpa bukti uji;
- membedakan data simulasi dari data sensor nyata.

## Non-Goals

Baseline assistant bukan:

- chatbot internet umum;
- alat diagnosis medis;
- pengganti dosen atau jobsheet resmi;
- bukti bahwa BLE/hardware fisik sudah teruji;
- LLM/RAG generatif.

## Baseline Cases Minimum

| ID  | Pertanyaan                                                   | Ekspektasi                                                                    |
| --- | ------------------------------------------------------------ | ----------------------------------------------------------------------------- |
| A01 | Apa langkah pertama sebelum menggunakan peralatan praktikum? | Sumber Evaluasi; jawaban memuat pemeriksaan prosedur keselamatan/kondisi alat |
| A02 | Apa format laporan yang disarankan?                          | Sumber Unggah Laporan; jawaban memuat PDF                                     |
| A03 | Layanan BLE apa yang diperlukan untuk membaca BPM nyata?     | Sumber Monitor Trainer; jawaban memuat BLE Heart Rate Service/0x180D          |
| A04 | Apakah data trainer digunakan untuk diagnosis medis?         | Sumber Monitor Trainer; jawaban menyatakan untuk pembelajaran/bukan diagnosis |
| A05 | Siapa presiden Indonesia saat ini?                           | Fallback; tidak ada sumber                                                    |

## Evaluasi Manual Mahasiswa

Tambahkan minimal 20-30 pertanyaan dari materi resmi dan nilai:

- source correctness;
- answer relevance;
- groundedness / unsupported claim;
- fallback correctness;
- completeness.

Gunakan skala yang konsisten, misalnya 0/1 per kriteria, lalu simpan hasil sebagai baseline sebelum bounded RAG/LLM.

## Arah Pengembangan Berikutnya

Jika LLM/RAG ditambahkan, retrieval harus tetap dibatasi pada sumber yang disetujui. Model tidak boleh menjawab dengan pengetahuan umum saat sumber lokal tidak mendukung jawaban. Setiap perubahan harus dibandingkan dengan baseline ini menggunakan set pertanyaan yang sama.
