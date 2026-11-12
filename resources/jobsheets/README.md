# Folder sumber Jobsheet

Simpan setiap edisi jobsheet sebagai **satu file JSON** dalam folder ini, misalnya `panduan-2027.json`. Halaman `/jobsheet` secara otomatis membaca semua file `.json` pada folder ini saat halaman dimuat; tidak perlu mengubah Blade atau route untuk menambah edisi.

## Format

```json
{
  "id": "panduan-2027",
  "title": "Panduan Praktikum 2027",
  "year": 2027,
  "author": "Nama penyusun",
  "status": "Draf / disetujui dosen",
  "source_file": "nama-asli.pdf",
  "source_note": "Catatan asal dokumen",
  "modules": [
    {
      "slug": "penguat-instrumentasi",
      "number": 1,
      "title": "Penguat Instrumentasi",
      "group": "Penguat Sinyal",
      "pdf_page": 10,
      "summary": "Ringkasan singkat sesuai sumber"
    }
  ]
}
```

- `id` harus unik antar edisi, `slug` harus unik di dalam satu edisi. Gunakan huruf kecil, angka, dan tanda hubung.
- Nomor `pdf_page` adalah halaman **fisik PDF** dimulai dari 1, bukan nomor cetak di footer.
- Jangan mengubah isi prosedur atau mengklaim validasi tanpa persetujuan dosen. Informasi dalam JSON harus diperiksa terhadap PDF asli.
- **Menaruh PDF saja belum otomatis mengubahnya menjadi JSON.** Ekstraksi dan verifikasi konten dari PDF baru harus dilakukan sebelum mengisi manifest. Folder ini menyimpan data terstruktur, sedangkan PDF sumber dapat disimpan terpisah sesuai kebijakan distribusi.
- Tidak menyimpan API key, data pasien, atau informasi pribadi praktikan di folder ini.

## Implementasi

Katalog dari `App\\Support\\JobsheetCatalog`; halaman `/jobsheet` dan `/jobsheet/{edition}/{module}` mengambil data melalui katalog ini. Jika JSON tidak valid, file dilewati (laporan kesalahan di log), sehingga halaman lain tetap dapat digunakan.

## Konten lengkap per modul

Setiap modul pada `modules/<slug>.json` berisi `schema_version`, `edition`, `slug`, `source`, `extraction_status`, dan daftar `pages`. Setiap page memiliki `pdf_page` (nomor halaman fisik mulai 1) dan `text` (teks sumber).

Halaman detail menggunakan `JobsheetCatalog::module()` untuk membaca konten modul sesuai edisi dan slug. Edisi tambahan yang memakai slug sama tetapi teks berbeda **belum boleh menggunakan** nama file modul yang sama: versi saat ini hanya membaca konten halaman bila `edition` cocok. Untuk edisi baru, buat penamaan file terpisah per edisi dan perluas pemetaan katalog sebelum publikasi.

**Kualitas ekstraksi:** Data 2019 berasal dari lapisan teks PDF. Beberapa tabel, rumus, dan gambar rangkaian belum dapat direkonstruksi secara akurat sebagai elemen HTML. Jangan mengandalkan ekstraksi ini sebagai panduan K3 untuk koneksi elektroda pada manusia; periksa dokumen asli dan minta supervisi dosen. PDF asli tidak disertakan di repository publik.

**Deploy Vercel:** Direktori `resources/jobsheets` terbawa ke image container saat `COPY . .`; data dibaca sebagai berkas read-only. Untuk mengubah isi, commit file JSON ke GitHub dan lakukan deployment baru. Jangan menyimpan unggahan pengguna secara permanen di filesystem container.
