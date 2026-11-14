# Rancangan lanjutan Asisten AI: bounded RAG dengan sumber terikat

**Status:** rancangan arsitektur, **bukan fitur LLM yang sudah diaktifkan**. Mengikuti tujuan PR #2: sumber yang dapat diaudit, cakupan materi jelas, perilaku fallback, dan kontrol terhadap klaim medis.

## Pipeline usulan

1. **Ingest terkurasi:** hanya RPS, modul dan jobsheet yang diizinkan dosen, disimpan dengan versi/edisi, penulis, halaman PDF, dan tanggal persetujuan.
2. **Ekstraksi terstruktur:** segmentasi menurut kompetensi/materi/prosedur, menjaga ID dokumen, nomor halaman, hash sumber, dan metadata revisi; jangan mengarang deskripsi rangkaian dari gambar yang belum diverifikasi.
3. **Retrieval:** gunakan pencarian kata kunci yang sudah ada sebagai baseline; opsi embeddings/hybrid search diuji hanya bila corpus dan evaluasi sudah memadai.
4. **Reranking dan threshold:** gunakan ukuran relevansi serta deteksi tidak ada bukti. Jika pertanyaan di luar sumber, kembalikan fallback, jangan memaksa jawaban.
5. **Generation terikat (opsional):** instruksikan model hanya menjawab dari potongan dokumen terambil; setiap klaim akademik memiliki sitasi sumber, edisi, halaman dan tautan yang valid.
6. **Safety gate:** larang diagnosis, normalisasi hasil sensor tanpa alat rujukan, dan saran pengukuran tubuh tanpa SOP. Minimalkan data pribadi.
7. **Audit:** log pertanyaan anonim, IDs dokumen, versi retrieval, keputusan fallback, durasi, dan revisi model. Tentukan retensi data dan persetujuan penelitian sebelum menyimpan event pengguna.

## Kriteria awal yang bisa diuji

- Jalankan korpus `baseline-cases.json` pada baseline dan kandidat baru dengan pertanyaan identik.
- Bandingkan source hit, kesalahan fallback, latensi, dan rubric manusia enam dimensi.
- Laporkan *unsupported claim rate* dan kasus saat jawaban terlihat yakin tetapi bukti tidak mencukupi.
- Lakukan split kasus pengembangan dan pengujian final untuk menghindari menyesuaikan sistem pada satu daftar pertanyaan saja.
- Jika tidak ada sumber resmi atau hasil evaluasi belum cukup, **tetap gunakan retrieval lokal**; jangan mengklaim bounded RAG siap digunakan.

## Keputusan implementasi

Belum diputuskan provider, model, database vektor, biaya hosting, atau penyimpanan dialog. Keputusan tersebut bergantung pada sumber resmi, privasi, penilaian dosen, dan kemampuan hosting; bukan prasyarat penyelesaian prototype pilot.
