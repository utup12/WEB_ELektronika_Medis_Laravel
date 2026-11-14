# Protokol evaluasi baseline Asisten AI — tindak lanjut PR #2

**Status:** instrumen evaluasi awal berbasis isi website/Jobsheet 2019; **belum tervalidasi sebagai representasi materi resmi** oleh dosen. Aplikasi memakai *local grounded retrieval* dan kalkulator terikat sumber; tidak ada LLM eksternal.

## Korporus dan metode

- Dataset: `resources/ai-evaluation/baseline-cases.json` berisi **28 pertanyaan**.
- Komposisi: **17 retrieval**, **5 kalkulasi AD620**, **4 di luar cakupan**, **2 sapaan**.
- Sumber rujukan awal: halaman aplikasi dan Jobsheet 2019, bukan RPS terbaru yang sudah disahkan.
- Jalankan `php scripts/evaluate_ai_baseline.php` setelah `composer setup` (memerlukan instalasi Laravel).
- Keluaran `build/ai-evaluation/results.csv` dan `results.json` memuat pertanyaan, jawaban yang dihasilkan, sumber, indikator kecocokan sumber, dan kecocokan cuplikan teks.
- GitHub Actions menyimpan berkas hasil sebagai artifact. **Source hit** dan **text hit** hanyalah pemeriksaan otomatis yang dangkal, **bukan** ukuran kebenaran, relevansi semantik, atau groundedness.

## Rubrik review manusia

Berikan skor setiap dimensi berdasarkan **jawaban aktual** dan **sumber aslinya**, bukan berdasarkan asumsi evaluator:

| Dimensi | 0 | 1 | 2 |
| --- | --- | --- | --- |
| Ketepatan sumber | Sumber tidak sesuai/absen saat diperlukan | Ada sumber terkait tetapi tidak tepat utama | Sumber tepat, bisa ditelusuri |
| Relevansi jawaban | Tidak menjawab maksud pertanyaan | Menjawab sebagian | Langsung menjawab inti |
| Groundedness | Klaim utama tanpa dukungan sumber | Sebagian klaim didukung | Semua klaim substantif didukung sumber |
| Unsupported claim | Ada klaim tak berdasar berisiko | Ada klaim kecil yang tak didukung | Tidak ada klaim tambahan tanpa dasar |
| Fallback correctness | Mengarang di luar scope/gagal menjawab saat sumber tersedia | Penolakan/rujukan kurang tepat | Menolak secara tepat di luar scope dan menjawab saat sumber memadai |
| Completeness | Unsur esensial tidak tersedia | Unsur utama ada namun terbatas | Unsur penting lengkap dan tidak berlebihan |

**Enam dimensi** tersebut masing-masing 0–2; skor total per pertanyaan 0–12. Beri `N/A` pada fallback untuk kasus yang secara metodologis tidak bisa dinilai; laporkan penyebut skor yang digunakan. Nilai tidak menjadi indikator efektivitas pembelajaran. Untuk soal perhitungan, periksa rumus, satuan, angka, dan kondisi batas secara manual.

## Prosedur pelaporan

1. Jalankan seluruh 28 kasus pada commit tertentu; simpan SHA, tanggal, environment, dan hasil raw.
2. Periksa tiap sumber dengan membuka halaman yang dirujuk dan mencocokkan potongan jawaban.
3. Isi penilaian manual pada salinan `results.csv` tanpa mengedit data mentah.
4. Hitung rata-rata dan distribusi skor **per dimensi**, persentase fallback benar untuk kasus out-of-scope, dan contoh kegagalan dengan kategori yang jelas.
5. Minta dosen memvalidasi atau mengganti pertanyaan agar sesuai RPS/jobsheet resmi sebelum memakai hasil sebagai data penelitian.
6. Jangan menyatakan skor auto source/keyword sebagai validitas/akurasi jawaban AI.

Batasan: hasil benchmark mesin bisa berubah saat materi, jobsheet, atau algoritma retrieval diperbarui. Simpan perbandingan berdasarkan commit SHA agar replikasi memungkinkan.
