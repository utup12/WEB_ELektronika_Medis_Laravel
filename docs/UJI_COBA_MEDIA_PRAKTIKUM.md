# Instrumen Audit dan Uji Coba Terbatas — Media Praktikum Elektronika Medis

**Status:** rancangan instrumen, **belum divalidasi dan belum digunakan**.

## A. Audit ahli materi oleh dosen pengampu

Isi setiap baris dengan skor 1–4 (1 = perlu perbaikan besar; 4 = sesuai),
bukti halaman/komponen, dan saran revisi. Skala ini merupakan rancangan
operasional untuk uji awal, bukan instrumen psikometrik teruji.

| Aspek | Indikator pemeriksaan | Bukti yang perlu diperiksa |
| --- | --- | --- |
| Keselarasan | Materi sesuai CPMK dan tujuan praktikum yang berlaku | RPS terbaru + jobsheet |
| Ketepatan | Persamaan dan satuan AD620 benar | PDF hlm. 16 |
| Pengukuran | Baris tabel AD620 sesuai sumber; tidak mengarang hasil | PDF hlm. 18 |
| Pengukuran | Frekuensi dan dB teoritis filter sesuai sumber | PDF hlm. 27–28 |
| Kejelasan | Tabel bantu Vin dibedakan dari kolom asli | Label tabel digital |
| Keselamatan | Prosedur catu daya dan pemeriksaan dosen benar | PDF hlm. 17 dan 25 |
| Visual | Rangkaian dan letak kaki komponen tidak salah | PDF serta datasheet komponen |
| Evaluasi | Pertanyaan diskusi tidak mengandung kunci fiktif | PDF hlm. 18 dan 29 |

## B. Uji fungsi browser

Gunakan Chrome/Edge/Firefox pada desktop dan peramban mobile.
Lakukan uji **tanpa menghubungkan rangkaian ke tubuh**.

| Kasus | Prosedur uji | Kriteria lulus |
| --- | --- | --- |
| Draf | Isi satu sel, simpan, muat ulang halaman, muat draf | Nilai kembali tanpa perubahan |
| Berkas | Ekspor JSON lalu impor ke modul yang sama | Data pulih dan rumus dihitung ulang |
| Isolasi | Impor draf AD620 ke modul LPF | Sistem menolak |
| Pengukuran | Biarkan Vin kosong lalu isi Vout | Penguatan dB tidak dibuat-buat |
| Nol | Isi Vin LPF dengan 0 | Baris diberi peringatan |
| Grafik | Isi dua baris LPF, lalu hapus satu | Tidak ada interpolasi hasil yang kosong |
| CSV | Unduh tabel dan buka di spreadsheet | Kolom, nilai, dan pemisah terbaca |
| Cetak | Isi diskusi kemudian pilih Print/PDF | Jawaban dan data terisi tampil |
| Privasi | Amati tab Network saat mengetik | Tidak ada pengiriman jawaban ke API AI |
| Responsif | Buka pada lebar layar ponsel | Tabel dapat digulir horizontal |

## C. Uji kepraktisan pengguna (rancangan)

Setelah mencoba modul, minta mahasiswa menilai 1–4 dan memberikan
komentar bebas untuk aspek keterbacaan, kemudahan navigasi,
kejelasan petunjuk, pengisian tabel, pemahaman grafik, kemudahan
menyimpan/mengekspor hasil, dan persepsi beban penggunaan.

**Jangan menginterpretasikan skor sebagai efektivitas pembelajaran**.
Efektivitas memerlukan desain evaluasi terpisah, indikator hasil belajar,
dan analisis yang sesuai.

## D. Log revisi

Catat tanggal, modul, temuan, tingkat risiko, bukti, keputusan revisi,
penanggung jawab, status perbaikan, dan hasil uji ulang.

## E. Pembatasan

- Materi masih mengacu pada panduan 2019, menunggu konfirmasi dosen.
- Pengujian fungsional otomatis tidak membuktikan keselamatan rangkaian fisik.
- Tidak menyimpan data pasien, biometrik, atau hasil pengukuran subjek manusia
  pada fitur website tanpa prosedur etik dan tata kelola data yang sesuai.
