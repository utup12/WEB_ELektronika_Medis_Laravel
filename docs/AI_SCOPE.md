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

## Tabel pengamatan digital dan diskusi (Jobsheet 2019)

Modul `penguat-ad620` memuat Tabel 3 (PDF halaman 18) dengan
10 nilai resistor yang sudah dicocokkan terhadap dokumen. Kolom Input 2 dan
Vout praktik tetap kosong sampai mahasiswa mengisi pengukuran.
Gain ideal dihitung dari `G = 1 + 49400/RG`; Vout teoritis dari selisih
input dikalikan gain, yang mungkin melebihi kemampuan catu daya nyata.

Modul `low-pass-orde-pertama` memuat Tabel 6 dan Tabel 7
(PDF halaman 27–28), dengan 13 frekuensi yang sesuai dokumen.
Nilai dB teoritis Tabel 6 dipertahankan sebagaimana tercetak, termasuk
nilai yang mungkin perlu ditinjau secara akademik.
Kolom input terukur (`Vin`) adalah **kolom bantu tambahan**, bukan
kolom PDF asli, untuk menghitung rasio dan `20log10(Vo/Vi)`.

Seluruh perhitungan dan ekspor CSV berlangsung di browser tanpa API.
Jawaban diskusi dapat diunduh sebagai teks. Data tidak dikirim ke server
dan hilang jika halaman dimuat ulang sebelum diekspor. Tidak ada
penilaian otomatis maupun klaim hasil praktikum yang sudah dilakukan.
Gambar rangkaian asli tetap harus diperiksa pada dokumen PDF.

## Grafik respons frekuensi Low Pass Filter

Halaman modul `low-pass-orde-pertama` kini menampilkan grafik SVG interaktif
untuk Tabel 6 dan Tabel 7. Sumbu frekuensi memakai skala logaritmik. Garis
teoritis hanya ditampilkan jika nilai `theoretical_db` tersedia pada data
tabel sumber (Tabel 6); untuk Tabel 7 tidak ada kurva teoritis rekaan.
Titik eksperimen dihitung dari Vin dan Vout yang diisi mahasiswa dengan
rumus `20 log10(Vout/Vin)`. Jika Vin atau Vout kosong/nonpositif,
titik eksperimen tidak digambar. Tidak ada interpolasi data kosong.

Mahasiswa dapat mengekspor grafik sebagai SVG tanpa mengunggah data.
Angka teoritis dipertahankan sebagaimana tercetak di jobsheet, termasuk
nilai yang tampak tidak mulus. Diagram rangkaian harus tetap diperiksa dari
PDF asli; grafik ini bukan salinan diagram rangkaian elektronik.

## Paket Ruang Kerja Praktikum (satu commit)

Untuk modul dengan aktivitas terverifikasi, halaman menyediakan fitur:
1. Persentase/kemajuan kelengkapan isian (bukan nilai kompetensi).
2. Identitas atau label laporan opsional.
3. Simpan/muat/hapus draf di localStorage **secara manual**, bukan autosave.
4. Ekspor dan impor draf JSON dengan validasi edisi, slug, jumlah tabel/baris, panjang jawaban, dan nilai numerik.
5. Cetak ringkasan pengamatan serta jawaban diskusi ke printer atau PDF browser.
6. Pengingat eksplisit bahwa hasil kosong bukan pengukuran dan rumus ideal bukan hasil uji alat.

Data tidak dikirim ke server maupun API LLM. Penyimpanan lokal tidak
sinkron antar perangkat. Jangan masukkan identitas pasien; pengguna
bertanggung jawab menyimpan berkas ekspor dengan aman. Validasi impor
menolak berkas lebih dari 256 KB atau dengan bentuk yang tidak sesuai.

## Paket uji coba mandiri dan pemeriksaan data

Pada modul AD620 dan Low Pass Orde Pertama ditambahkan daftar cek
persiapan berbasis langkah umum K3 dalam Jobsheet 2019. Checklist
hanya pencatatan mandiri, bukan sertifikat keselamatan, persetujuan
dosen, ataupun hasil validasi perangkat. Status cek dapat disimpan
di draf JSON dan akan tertera pada laporan cetak. Draf lama tanpa
daftar cek masih dapat diimpor; semua kotak akan dimulai tanpa centang.

Pemeriksaan data di browser menandai baris dengan isian numerik
tidak valid. Untuk filter, penguatan dB hanya dapat dihitung jika
Vin dan Vout positif. Untuk AD620, keluaran ideal yang mencapai atau
melebihi 12 V ditandai sebagai potensi keterbatasan akibat catu
simetris ±12 V yang disebut di panduan. Peringatan bukan prediksi
output fisik aktual. Tidak ada data eksperimen yang dibuat otomatis.

## Rancangan uji coba terbatas

Uji pengalaman pengguna dilakukan hanya setelah deployment berhasil,
konten disetujui dosen, dan SOP K3 disepakati. Lakukan uji secara
terpisah terhadap akurasi konten, fungsi antarmuka, dan kepraktisan.
Simpan data observasi/feedback terpisah dari data kesehatan atau
identitas pasien. Hasil pengujian belum tersedia; tidak ada klaim
kelayakan, kepraktisan, atau efektivitas dari kode saja.
