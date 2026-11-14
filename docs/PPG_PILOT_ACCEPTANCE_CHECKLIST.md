# Checklist penerimaan pilot Heart Rate / PPG

Status: draf pembelajaran, **bukan modul resmi** dan **bukan alat diagnosis**.

## Bukti otomatis (CI)
- [ ] GitHub Actions pada commit `main` terakhir berstatus sukses.
- [ ] Tes `HeartRatePilotFlowTest` memastikan rute publik, tautan Materi, Evaluasi, Jobsheet, Praktikum, dan Laporan.
- [ ] Pemeriksaan PHP, frontend, dan JavaScript selesai tanpa kegagalan.

## Uji browser manual (belum boleh diklaim lulus tanpa pelaksanaan)
- [ ] Buka `/materi`, pilih pilot PPG, pastikan bagian `#pilot-learning` terlihat.
- [ ] Buka `/evaluasi` dan `/jobsheet`, ikuti tautan pilot.
- [ ] Pre-lab: jawaban benar seluruhnya menampilkan 3/3; jawaban keliru memberi umpan balik; tanpa pilihan, formulir menahan submit.
- [ ] Buka `/monitor-trainer`, pastikan label mode SIMULASI jelas dan grafik dapat berjalan; jangan menganggapnya data sensor.
- [ ] Isi mode, pengamatan, interpretasi, refleksi; klik Simpan draf lokal; muat ulang dan pastikan isian kembali.
- [ ] Ekspor TXT dan periksa isi berkas; hapus draf dan pastikan isian kosong.
- [ ] Buka `/laporan`, pastikan informasi penyimpanan lokal tidak disalahartikan sebagai pengiriman ke dosen.
- [ ] Uji layar sempit (ponsel), keyboard, dan menu navigasi.
- [ ] Periksa console dan Network browser untuk error JavaScript, HTTP 404, dan aset gagal muat.
- [ ] Periksa bahwa tidak ada data pasien atau identitas subjek dimasukkan ke catatan.

## Validasi akademik dan hardware (menunggu bukti eksternal)
- [ ] Dosen mengonfirmasi kesesuaian tujuan, materi, soal, prosedur, dan rubrik dengan RPS/jobsheet.
- [ ] Prosedur K3 rangkaian fisik disahkan sebelum pengukuran pada manusia.
- [ ] Perangkat PPG diuji terhadap alat rujukan dan diuji kualitas sinyal/artefak dengan protokol terdokumentasi.
- [ ] Pengujian kepraktisan dan efektivitas dilakukan dengan instrumen penelitian yang tervalidasi.

## Aturan rilis
Pengembangan hanya di `main`. **Jangan** mengubah `deployment/vercel` atau memicu rilis produksi sebelum persetujuan eksplisit pengguna, CI hijau, dan uji browser tercatat.
