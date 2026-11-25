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

## Hasil uji ulang pada build Laravel terbaru (`6ce009d`)

| Parameter | Hasil Pengujian Ulang |
| --- | --- |
| Tanggal & waktu uji | 25 November 2026, pukul 12:27–12:28 WIB (terlihat pada jam smartwatch) |
| URL & build yang diuji | `https://praktik-elkamedis.vercel.app/monitor-trainer` (commit `6ce009d`) |
| Perangkat BLE | Smartwatch Advan S2A (`S2A - Paired`) |
| Perangkat & browser penguji | Laptop Windows (Acer) menggunakan browser Brave (Web Bluetooth) |
| Status awal & pairing | Status awal `SIMULASI`; dialog Web Bluetooth menampilkan `S2A - Paired` (`01-ble-pairing-dialog.png`) |
| Transisi ke BLE LIVE | Status berubah menjadi `MODE BLE` / `BLE LIVE` dengan disclaimer non-klinis (`02-ble-live-89bpm.png`) |
| Sampel BPM teramati (sinkron jam & web) | 1. **89 BPM** (`02-ble-live-89bpm.png`)<br>2. **92 BPM** pada **12:27** (`03-ble-live-92bpm-1227.png`)<br>3. **94 BPM** pada **12:28** (`04-ble-live-94bpm-1228.png`)<br>4. **93 BPM** pada **12:28** (`05-ble-live-93bpm-1228.png`) |
| Lokasi berkas bukti | `docs/evidence/ble-retest-2026-11-25/` |

## Verifikasi yang masih perlu dilampirkan

- [x] Identitas tipe perangkat smartwatch dilaporkan: Advan S2A (`S2A - Paired`).
- [x] Service/characteristic BLE (`0x180D` / `0x2A37`) dan contoh hasil BPM dilaporkan.
- [x] Screenshot/foto asli dimasukkan ke repository (`docs/evidence/ble-retest-2026-11-25/`) tanpa identitas atau data kesehatan pribadi.
- [x] Situs Laravel **versi commit terbaru (`6ce009d`)** diuji ulang melalui HTTPS (`https://praktik-elkamedis.vercel.app/monitor-trainer`) dari pairing hingga `BLE LIVE`.
- [x] Minimal tiga sampel BPM dan timestamp yang benar-benar terlihat pada sesi uji ulang dicatat (`89`, `92 @ 12:27`, `94 @ 12:28`, `93 @ 12:28`).
- [ ] Lengkapi catatan versi OS/browser spesifik, durasi total sesi, serta log verifikasi langkah `DISCONNECT → SIMULASI` dan pemulihan error.
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
