# Sumber Jobsheet

Folder ini menyimpan data pembelajaran yang dipublikasikan melalui Laravel.

## Struktur

- `panduan-2019.json`: katalog edisi 2019.
- `modules/<slug>.json`: teks per halaman untuk satu modul.
- PDF asli tidak disertakan dalam repository publik.

## Edisi baru

Tambahkan file katalog JSON baru dengan `id` unik dan daftar `modules`.
Kolom modul: `slug`, `number`, `title`, `group`, `pdf_page`, `summary`.
`pdf_page` merujuk nomor halaman fisik PDF, dimulai dari satu.

Konten halaman disimpan dalam file modul dengan kolom `edition`, `slug`,
`source`, `extraction_status`, dan `pages`. Setiap halaman memiliki
`pdf_page` dan `text`. Jika tersedia, `verified_equations` berisi
`label`, `expression`, `note`, dan `pdf_page`.

**Penting:** Mengunggah PDF saja tidak otomatis menghasilkan JSON.
Ekstraksi harus diperiksa, khususnya tabel, rumus dan diagram.
Untuk edisi baru dengan slug modul yang sama, pemetaan nama file
perlu diperluas agar edisi tidak saling menimpa.

## Batasan dan keamanan

Data 2019 adalah referensi sementara, bukan pengesahan kurikulum terkini.
Ikuti arahan dosen dan prosedur K3 untuk praktikum pada manusia.
Jangan menyimpan API key atau data pasien di folder ini.

## Deploy

Pada Vercel container, data JSON disertakan saat build dan dibaca read-only.
Perubahan isi membutuhkan commit GitHub dan deployment ulang.
Jangan menyimpan unggahan permanen pada filesystem container.
