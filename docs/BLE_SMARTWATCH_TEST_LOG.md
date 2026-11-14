# Catatan uji BLE smartwatch — Heart Rate / PPG

**Status:** bukti konektivitas prototipe berdasarkan pengujian pengguna terdahulu; **bukan validasi akurasi atau uji klinis**. Catatan ini dibedakan dari pengujian ulang pada deployment Laravel terbaru.

## Hasil yang pernah dilaporkan

| Parameter | Sesi nRF Connect | Sesi browser Brave |
| --- | --- | --- |
| Tanggal pengujian historis | 19 September 2026 | 19 September 2026 |
| Perangkat BLE | Smartwatch Advan S2A | Smartwatch Advan S2A |
| Antarmuka penguji | nRF Connect | Browser Brave / Web Bluetooth |
| Service | Heart Rate Service `0x180D` | Heart Rate Service `0x180D` |
| Characteristic | Heart Rate Measurement `0x2A37`, NOTIFY | Heart Rate Measurement `0x2A37`, NOTIFY |
| Hasil yang dilaporkan | 95 BPM, contact detected | 85 BPM, paket `0x06 0x55` |
| Konfirmasi koneksi | Pengguna melaporkan notifikasi berjalan | Pengguna melaporkan notifikasi real-time berhasil |
| OS dan versi browser | Tidak terdokumentasi secara lengkap | Versi Brave dan OS belum terdokumentasi |
| Durasi uji | Belum ada catatan durasi | Belum ada catatan durasi |
| Error/kendala | Belum tercatat sistematis | Belum tercatat sistematis |
| Screenshot/log di repository | Belum dilampirkan | Belum dilampirkan |

Pada 14 November 2026 pengguna kembali mengonfirmasi bahwa pengujian menggunakan smartwatch berhasil. Angka di atas adalah **laporan historis dua sesi**, bukan dua nilai dari eksperimen yang sama, bukan statistik akurasi, dan bukan bukti bahwa halaman Laravel pada commit terbaru telah diuji ulang pada perangkat tersebut.

Paket `0x06 0x55` pada characteristic standar bermakna flag `0x06` (format BPM 8-bit) dan nilai `0x55` = **85 BPM**. Angka tersebut menunjukkan dekode paket, bukan validasi terhadap pengukuran rujukan.

## Verifikasi yang masih perlu dilampirkan

- [x] Identitas tipe perangkat smartwatch dilaporkan pada percakapan historis: Advan S2A.
- [x] Service/characteristic BLE dan contoh hasil BPM dilaporkan.
- [ ] Screenshot/log asli dimasukkan ke repository dengan izin, tanpa identitas atau data kesehatan pribadi.
- [ ] Browser, versi, OS, tanggal/jam dan durasi tiap sesi dicatat dalam lembar pengujian yang dapat diaudit.
- [ ] Situs Laravel **versi commit terbaru** diuji ulang melalui HTTPS/localhost: CONNECT → BLE WAIT → BLE LIVE → DISCONNECT → SIMULASI.
- [ ] Minimal tiga sampel BPM dan timestamp yang benar-benar terlihat pada sesi uji ulang dicatat.
- [ ] Kegagalan koneksi, izin browser, pemulihan disconnect, dan pembacaan 8/16-bit diuji.
- [ ] Jika penelitian memerlukan validitas pengukuran, lakukan perbandingan terhadap alat rujukan dengan protokol dan izin sesuai arahan dosen.

## Protokol uji ulang yang aman

1. Pastikan aplikasi lain seperti nRF Connect sudah *disconnect* agar perangkat dapat digunakan browser.
2. Buka `/monitor-trainer` pada origin HTTPS atau localhost dari browser yang mendukung Web Bluetooth.
3. Catat identitas perangkat dan kondisi pengujian tanpa data pasien.
4. Periksa label SIMULASI, tekan Connect Bluetooth, pilih Advan S2A atau perangkat kompatibel yang tampil.
5. Pastikan label BLE WAIT terlihat sebelum notifikasi valid; setelah BPM diterima, baru label BLE LIVE dan nilai BPM aktual diperbarui.
6. Simpan screenshot yang tidak mengandung informasi sensitif. Catat lama koneksi, angka BPM teramati, status izin, serta error.
7. Tekan Disconnect, pastikan simulasi kembali dan label tidak menyesatkan.

Pengujian ini memverifikasi **alur data BLE dan antarmuka**, bukan kebenaran klinis, akurasi PPG, ataupun keselamatan rangkaian fisik. Jangan menghubungkan rangkaian rakitan ke tubuh tanpa supervisi/SOP K3 yang disahkan.
