# Scope AI dan Baseline Evaluasi

## Status Saat Ini

Asisten memakai retrieval lokal dari halaman Laravel dan teks Jobsheet 2019. Penggunaan LLM generatif bersifat opsional setelah API key server dikonfigurasi. Tanpa key, jawaban tetap berupa kutipan sumber lokal.

Baseline retrieval tetap dipertahankan sebagai pembanding untuk pengujian fitur generatif.

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

## Integrasi Tutor LLM Opsional (November 2026)

Asisten kini mencari teks pada 14 modul Jobsheet 2019 dan mempertahankan
baseline halaman website untuk pertanyaan umum. Jika API LLM dikonfigurasi,
**hanya jawaban retrieval jobsheet yang memiliki URL sumber halaman** yang
akan dikirim sebagai konteks kepada provider. Mode ini merupakan bounded
retrieval-augmented generation sederhana, **bukan** sistem RAG tervalidasi.

Konfigurasi environment **di server Vercel**, bukan di JavaScript frontend:

```dotenv
JOBSHEET_LLM_API_KEY=isi-dari-provider
JOBSHEET_LLM_MODEL=gpt-4.1-mini
JOBSHEET_LLM_URL=https://api.openai.com/v1/chat/completions
```

Gunakan endpoint HTTPS API chat-completions yang kompatibel; contoh di atas
menggunakan OpenAI. Kunci harus disimpan sebagai Vercel Environment Variable
untuk environment yang dipakai lalu lakukan redeploy. Langganan ChatGPT bukan
kredit API. Permintaan ke LLM memakai jaringan dan dapat dikenakan biaya.

### Perilaku yang sengaja dibatasi

- Tanpa key, URL non-HTTPS, timeout, atau respons provider gagal, asisten
  tetap mengembalikan kutipan asli dari jobsheet.
- Pencarian tidak mendukung seluruh variasi bahasa; pertanyaan yang tidak
  menemukan kecocokan akan masuk fallback pencarian halaman website.
- Model diberi instruksi mengabaikan instruksi yang terdapat dalam teks
  sumber, tetapi **risiko halusinasi masih ada**. Nomor halaman dan tautan
  sumber ditentukan oleh backend, bukan model.
- Jawaban klinis atau keselamatan perangkat yang melibatkan tubuh manusia
  tetap membutuhkan supervisi dosen dan pemeriksaan sumber asli.
- Jangan memasukkan data pasien, informasi kesehatan personal, atau rahasia
  dalam pertanyaan, karena pertanyaan dan kutipan yang relevan dikirim ke API.
- Evaluasi 20–30 pertanyaan tetap dibutuhkan sebelum klaim validitas hasil.
