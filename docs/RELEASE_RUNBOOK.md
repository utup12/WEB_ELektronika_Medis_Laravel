# Panduan Rilis Terkendali — Elektronika Medis

**Tujuan:** mencegah banyak deployment Vercel akibat commit berulang, dan memastikan kode sudah lulus CI sebelum rilis.

## Kondisi per 12 November 2026

- Repository: `utup12/WEB_ELektronika_Medis_Laravel`.
- Branch produksi: `main`.
- Hosting: Vercel, preset `framework: container`.
- GitHub Actions berhasil, tetapi pemeriksaan Vercel memberi `build-rate-limit`.
- Masalah pembatasan build tidak membuktikan bahwa PHP/Laravel atau JavaScript aplikasi rusak.
- Jangan memasukkan API key LLM; asisten memakai pencarian lokal.
- Kami tidak mempunyai akses ke pengaturan/usage akun Vercel melalui GitHub connector.

## Langkah uji sebelum rilis

1. Periksa halaman GitHub Actions pada branch `main`.
2. Jalankan workflow `tests` melalui tombol **Run workflow** bila ingin menguji tanpa commit baru.
3. Pastikan pemeriksaan format, tipe, tes PHP, dan sintaks JavaScript lulus.
4. Lakukan uji interaksi di browser setelah kode dapat di-deploy:
   - Katalog dan halaman 14 jobsheet dapat dibuka;
   - Asisten menjawab dengan sumber lokal, tidak mengirim ke API AI;
   - AD620 menampilkan gain/RG yang benar;
   - Tabel 3 AD620, Tabel 6–7 LPF dapat menerima pengukuran;
   - Grafik LPF berubah sesuai isian tanpa mengarang data kosong;
   - Simpan/muat/ekspor/impor draf dan cetak laporan;
   - Checklist K3 tidak diklaim sebagai sertifikasi keselamatan.
5. Catat hasil di `docs/UJI_COBA_MEDIA_PRAKTIKUM.md`; dokumentasikan temuan dan revisi.

## Ketika Vercel memberi `build-rate-limit`

1. Hentikan push berulang semata-mata untuk memicu Vercel; ulang tes di GitHub Actions menggunakan `workflow_dispatch`.
2. Periksa proyek **Vercel Dashboard → Deployments**, dan **Usage** pada akun/team yang tepat.
3. Dokumentasi Vercel Hobby menyebut 32 builds per jam dan 100 deployments per hari. Tidak semua kegagalan rate limit berarti batas tertentu pasti telah tercapai. Jangan menebak durasi pembatasan dari status GitHub saja.
4. Setelah kuota memungkinkan, lakukan **satu** redeploy terhadap commit `main` terbaru yang lulus CI. Pastikan SHA yang dibangun sama dengan SHA terbaru di GitHub.
5. Bila redeploy kembali ditolak bahkan ketika penggunaan sebenarnya masih rendah atau pembatasan telah melewati jendela resmi, simpan tangkapan layar/status dan hubungi dukungan Vercel atau forum Vercel dengan project/team ID dari dashboard, tanpa membagikan secret.

## Mengurangi build tak perlu

- Lakukan perubahan banyak berkas dalam **satu commit teruji**, bukan banyak commit kecil.
- CI di repo ini membatalkan run GitHub Actions lama yang masih berjalan untuk ref yang sama. Ini menghemat CI, **tidak secara otomatis membatasi deployment Vercel**.
- GitHub Actions kini mendukung **Run workflow** manual, tanpa membuat commit dan tanpa memicu deployment Vercel.
- Vercel memiliki Ignored Build Step, tetapi menurut dokumentasi resminya build yang dibatalkan melalui langkah tersebut masih dapat dihitung sebagai deployment/slot build. Jangan menganggapnya solusi kuota.
- Jika ingin sepenuhnya mengendalikan kapan GitHub memicu Vercel, gunakan pengaturan integrasi Git pada Vercel; perlu dipertimbangkan dengan hati-hati karena bisa menghentikan update otomatis. **Tidak diubah oleh commit ini.**

## Kriteria siap uji coba

Kelayakan teknis awal adalah CI sukses dan semua fungsi utama terbukti berjalan di URL deployment yang aktif. Kelayakan materi, K3, kepraktisan, dan efektivitas pembelajaran memerlukan validasi dosen/mahasiswa secara terpisah; tidak dapat disimpulkan dari jumlah tes yang lulus.

## Referensi resmi

- https://vercel.com/docs/limits
- https://vercel.com/docs/project-configuration/project-settings
- https://vercel.com/docs/project-configuration/git-configuration
- https://vercel.com/docs/builds

## Perbaikan endpoint Asisten AI pada domain Preview

Frontend asisten harus mengirim POST ke path relatif `/asisten-ai/chat`
di origin yang sedang dibuka. Laravel `route('asisten-ai.chat', [], false)`
menghindari form `action` absolut menuju domain `APP_URL` Production
ketika mahasiswa menguji halaman melalui domain Vercel Preview.
Tes fitur memeriksa HTML `action` tetap relatif meskipun
`APP_URL` berbeda dari host request.

Jika pengguna melihat HTTP 419, periksa pengaturan session/CSRF
dan muat ulang halaman. Jika error HTTP 5xx, lihat Vercel runtime logs.
Jika masih muncul kesalahan jaringan, gunakan browser DevTools
Network untuk memeriksa Request URL, Status, dan kemungkinan redirect/CORS.
Jangan menonaktifkan CSRF atau membuka CORS wildcard untuk mengatasinya.

## Aset dan navigasi lintas domain Preview/Production

Template Asisten AI memakai URL berbasis root `/css/*`, `/js/*`,
`/assets/*` serta route relatif Laravel `route(name, [], false)`.
Tujuannya agar gambar, CSS, JS, form POST, dan tautan navigasi tetap
mengarah ke origin Vercel yang sedang dibuka. URL dari helper `asset()`
dapat terpengaruh `APP_URL`, `ASSET_URL`, dan header proxy sehingga
perlu diaudit khusus dalam deployment Preview.

Jika halaman tampak tanpa gaya, cek DevTools Network untuk status
`/css/styles.css`, `/css/identity.css`, `/css/ai.css`,
`/js/script.js`; pastikan request memakai hostname halaman.
Perbaikan asset tidak dengan sendirinya membuktikan bahwa request POST
chat berhasil; diagnostik CSRF/session harus diuji terpisah.
