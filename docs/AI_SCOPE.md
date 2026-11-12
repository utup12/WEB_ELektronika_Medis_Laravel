# Ruang Lingkup Asisten Praktikum (100% Lokal)

## Status

Asisten kini berjalan di backend Laravel tanpa panggilan API AI eksternal.
Tidak ada konfigurasi API key atau model generatif yang diperlukan.

Tiga fungsi utama:

- Pencarian berbasis kata kunci pada halaman pembelajaran dan 14 modul Jobsheet 2019.
- Tutor berbasis aturan: menampilkan kutipan relevan dengan judul modul serta tautan halaman PDF.
- Kalkulator AD620: menghitung RG dari gain, atau gain dari RG, berdasarkan persamaan pada Jobsheet 2019 halaman PDF 16.

## Perhitungan AD620

Persamaan rujukan: `G = 1 + (49.400 Ω / RG)`.

Contoh pertanyaan:

- `Hitung RG AD620 untuk gain 100 kali` → RG ≈ 498,99 Ω.
- `Hitung gain AD620 jika RG 1 kΩ` → G = 50,40 kali.
- Gain harus lebih besar dari 1; resistor harus bernilai positif dengan satuan yang jelas.

Perhitungan merupakan model ideal untuk belajar, bukan hasil pengukuran aktual.

## Keterbatasan

- Sistem ini bukan model bahasa generatif dan tidak memiliki pemahaman bebas seperti ChatGPT.
- Pencarian masih bergantung pada istilah dan kelengkapan teks ekstraksi PDF; jawaban dapat meleset.
- Diagram rangkaian, tabel serta rumus yang belum diverifikasi harus dilihat pada dokumen asli.
- Konten Jobsheet 2019 digunakan sebagai referensi sementara, bukan pengesahan kurikulum terbaru.
- Asisten tidak melakukan diagnosis, tidak memastikan keamanan koneksi elektroda ke manusia, dan tidak memvalidasi hardware.
- Untuk praktikum dengan subjek manusia, ikuti supervisi dosen dan prosedur K3 resmi.

## Evaluasi yang perlu dilakukan

Siapkan 20–30 pertanyaan mencakup materi, perhitungan, pertanyaan ambigu, dan di luar cakupan. Nilai ketepatan sumber, relevansi jawaban, kecukupan informasi, kesalahan unsupported, dan perilaku fallback.

## Deployment

Data sumber berupa JSON dalam `resources/jobsheets/`. Laravel membaca file itu dari container Vercel ketika melayani permintaan. Pencarian dan kalkulator tidak memanggil API AI. Perbarui JSON melalui GitHub `main`, kemudian deploy image baru ke Vercel.

Sisa environment variable `JOBSHEET_LLM_*` yang mungkin pernah disimpan di pengaturan Vercel tidak digunakan lagi oleh kode terbaru; administrator dapat menghapusnya secara manual.
