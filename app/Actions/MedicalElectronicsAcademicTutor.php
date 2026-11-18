<?php

namespace App\Actions;

class MedicalElectronicsAcademicTutor
{
    /**
     * Handle comprehensive academic and medical electronics inquiries with university-level rigor.
     *
     * @return array{answer: string, sources: array<int, array{title: string, url: string}>}|null
     */
    public function answer(string $question): ?array
    {
        $text = mb_strtolower(trim($question));

        // 1. SMARTWATCH, BLE & HEART RATE MONITORING
        if (preg_match('/(?:smartwatch|ble|bluetooth|0x180d|0x2a37|heart\s*rate\s*service|baca\s*bpm|denyut\s*jantung|detak\s*jantung|monitoring\s*heart)/u', $text)
            && (preg_match('/(?:cara|bagaimana|monitoring|baca|kerja|protokol|fungsi|penjelasan|smartwatch|ble|trainer)/u', $text))) {
            return [
                'answer' => "**Kajian Akademik: Sistem Monitoring Heart Rate Menggunakan Smartwatch & Protokol BLE**\n\n"
                    ."1. **Arsitektur Konektivitas (Bluetooth Low Energy - GATT Profile):**\n"
                    ."Pengukuran detak jantung nirkabel dari smartwatch memanfaatkan profil standar GATT (*Generic Attribute Profile*). Perangkat bertindak sebagai *GATT Server* yang mengekspos layanan standar Bluetooth SIG:\n"
                    ."- **Heart Rate Service (UUID 0x180D):** Layanan utama telemetri denyut jantung.\n"
                    ."- **Heart Rate Measurement Characteristic (UUID 0x2A37):** Karakteristik pengiriman data asinkron (*Notify*).\n\n"
                    ."2. **Struktur Paket Data (Payload Framing):**\n"
                    ."Paket data yang diterima browser melalui Web Bluetooth API terdiri dari:\n"
                    ."- **Byte 0 (Flags):** Bit 0 menentukan format BPM (0 = nilai integer 8-bit [0–255], 1 = 16-bit [0–65535]). Bit 1–2 menandakan status kontak sensor dengan kulit. Bit 4 menandakan keberadaan interval RR (*inter-beat interval*).\n"
                    ."- **Byte 1–2:** Nilai denyut jantung aktual dalam satuan BPM (*Beats Per Minute*).\n"
                    ."- **Byte Tambahan (Opsional):** Data energi terpakai (kJ) dan durasi interval RR (resolusi 1/1024 detik).\n\n"
                    ."3. **Prinsip Akuisisi Sensorik (PPG Optik):**\n"
                    ."Smartwatch menggunakan sensor fotopletismografi (PPG) dengan LED hijau (panjang gelombang ~525–535 nm) dan fotodetektor. Perubahan volume darah mikrovaskular arteri selama siklus sistolik dan diastolik memodulasi penyerapan cahaya hijau. Mikrokontroler smartwatch memproses gelombang pulsatil ini dengan algoritma *peak detection* untuk menghitung frekuensi denyut:\n"
                    ."\\[ \\text{BPM} = \\frac{60}{\\Delta t_{\\text{peak-to-peak}}} \\]\n\n"
                    ."4. **Implementasi pada Platform Praktikum:**\n"
                    ."Di website ini, mahasiswa dapat menghubungkan smartwatch secara langsung melalui halaman **Monitor Trainer** atau modul **Candidate Pilot Heart Rate**. Jika perangkat fisik belum tersedia, sistem menyediakan mode simulasi sintetis matematis untuk mempelajari interpretasi sinyal dan artefak gerak.\n\n"
                    ."*Catatan Keselamatan Akademik:* Data smartwatch dan trainer pembelajaran ditujukan untuk keperluan praktikum instrumentasi, bukan alat diagnosis klinis tervalidasi.",
                'sources' => [
                    ['title' => 'Monitor Trainer', 'url' => route('monitor-trainer')],
                    ['title' => 'Candidate Pilot Heart Rate / PPG', 'url' => route('pilot.heart-rate')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                ],
            ];
        }

        // 2. PHOTOPLETHYSMOGRAPHY (PPG) & PULSE OXIMETRY
        if (preg_match('/(?:ppg|fotopletismografi|photoplethysmography|spo2|oksimetri|oximetry)/u', $text)) {
            return [
                'answer' => "**Kajian Teori: Photoplethysmography (PPG) & Oksimetri Pulsa**\n\n"
                    ."1. **Prinsip Fisika Dasar (Hukum Beer-Lambert):**\n"
                    ."Photoplethysmography (PPG) adalah teknik optik non-invasif untuk mengukur perubahan volume darah pada jaringan mikrovaskular perifer. Intensitas cahaya yang ditransmisikan atau dipantulkan memenuhi persamaan atenuasi optik:\n"
                    ."\\[ I = I_0 \\cdot e^{-\\epsilon(\\lambda) \\cdot c \\cdot d} \\]\n"
                    ."di mana \\(\\epsilon(\\lambda)\\) adalah koefisien kepunahan molar hemoglobin pada panjang gelombang \\(\\lambda\\), \\(c\\) adalah konsentrasi, dan \\(d\\) adalah panjang lintasan optik.\n\n"
                    ."2. **Dua Komponen Sinyal PPG:**\n"
                    ."- **Komponen DC (Quasi-Static):** Berasal dari penyerapan cahaya konstan oleh jaringan kulit, tulang, cairan interstitial, dan aliran darah vena yang tidak berdenyut.\n"
                    ."- **Komponen AC (Pulsatile):** Berasal dari ekspansi arteri saat darah dipompa oleh ventrikel jantung (fase sistolik). Amplitudo AC mencerminkan denyut volume darah setempat.\n\n"
                    ."3. **Pengukuran Saturasi Oksigen (SpO2):**\n"
                    ."Oksimetri pulsa menggunakan dua panjang gelombang cahaya spesifik:\n"
                    ."- **Cahaya Merah (Red ~660 nm):** Diserap lebih kuat oleh deoksihemoglobin (Hb tereduksi).\n"
                    ."- **Cahaya Inframerah (IR ~940 nm):** Diserap lebih kuat oleh oksihemoglobin (\\(\\text{HbO}_2\\)).\n"
                    ."Rasio modulasi \\(R = \\frac{(\\text{AC}/\\text{DC})_{\\text{Red}}}{(\\text{AC}/\\text{DC})_{\\text{IR}}\\) dipetakan secara empiris untuk menghitung persentase \\(\\text{SpO}_2\\).\n\n"
                    ."4. **Sumber Gangguan (Artefak) dalam Praktikum:**\n"
                    ."- **Motion Artifact:** Pergeseran relatif elektroda/sensor terhadap kulit mendistorsi sinyal AC.\n"
                    ."- **Ambient Light:** Cahaya lampu ruangan (50/100 Hz dari neon/LED) dapat bocor ke fotodioda bila pelindung optik kurang rapat.\n"
                    ."- **Vasokonstriksi Perifer:** Suhu dingin menurunkan perfusi perifer sehingga amplitudo AC melemah.",
                'sources' => [
                    ['title' => 'Candidate Pilot Heart Rate / PPG', 'url' => route('pilot.heart-rate')],
                    ['title' => 'Monitor Trainer', 'url' => route('monitor-trainer')],
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                ],
            ];
        }

        // 3. PENGUAT INSTRUMENTASI (IN-AMP) & AD620
        if (preg_match('/(?:ad\s*-?620|in-amp|instrumentation\s*amp|penguat\s*instrumentasi)/u', $text)
            && ! preg_match('/(?:hitung|kalkulasi|berapa|cari\s+nilai)/u', $text)) {
            return [
                'answer' => "**Analisis Akademik: Penguat Instrumentasi (Instrumentation Amplifier) AD620**\n\n"
                    ."1. **Karakteristik & Keunggulan Komparatif:**\n"
                    ."AD620 adalah monolithic instrumentation amplifier berbasis arsitektur 3 op-amp termodifikasi dengan keunggulan utama dalam instrumentasi medis:\n"
                    ."- **High Common-Mode Rejection Ratio (CMRR):** Mencapai \\(>100\\text{ dB}\\) pada penguatan tinggi (G = 100), krusial untuk menekan tegangan derau mode bersama (noise 50 Hz jala-jala listrik).\n"
                    ."- **Ultra-High Input Impedance:** \\(10\\text{ G}\\Omega \\parallel 2\\text{ pF}\\), mencegah fenomena pembebanan (*loading effect*) akibat resistansi antarmuka elektroda-kulit yang bernilai puluhan k\\(\\Omega\\).\n"
                    ."- **Low Input Bias Current:** Maksimal \\(0{,}5 - 2\\text{ nA}\\), meminimalkan tegangan offset DC.\n\n"
                    ."2. **Persamaan Penguatan (Gain Equation):**\n"
                    ."Penguatan tegangan (\\(G\\)) dikonfigurasi secara presisi hanya dengan satu resistor eksternal \\(R_G\\) yang dihubungkan di antara Pin 1 dan Pin 8:\n"
                    ."\\[ G = 1 + \\frac{49{,}4\\text{ k}\\Omega}{R_G} \\]\n"
                    ."Untuk menentukan nilai resistor pengatur penguatan bagi target \\(G\\) tertentu:\n"
                    ."\\[ R_G = \\frac{49{,}4\\text{ k}\\Omega}{G - 1} = \\frac{49.400\\ \\Omega}{G - 1} \\]\n\n"
                    ."3. **Aplikasi pada Praktikum Elektronika Medis:**\n"
                    ."Pada sistem akuisisi biopotensial (ECG, EMG, EEG), amplitudo sinyal tubuh sangat lemah (orde mikrovolt hingga milivolt). AD620 digunakan sebagai penguat tahap pertama (*pre-amplifier*) untuk menaikkan amplitudo sinyal biopotensial sebelum masuk ke rangkaian filter aktif dan ADC.\n\n"
                    ."*Peringatan Keselamatan Praktikum:* Rangkaian uji laboratorium tidak boleh dihubungkan langsung ke tubuh manusia tanpa rangkaian proteksi isolasi galvanis sesuai standar IEC 60601-1.",
                'sources' => [
                    ['title' => 'Jobsheet Penguat AD620 · halaman PDF 16', 'url' => route('jobsheet.module', ['edition' => 'panduan-instrumentasi-elektronika-medis-2019', 'module' => 'penguat-ad620'])],
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                ],
            ];
        }

        // 4. BIOPOTENSIAL (ECG, EMG, EEG)
        if (preg_match('/(?:ecg|ekg|emg|eeg|biopotensial|biosinyal|potensial\s*aksi|jantung|otot|otak)/u', $text)
            && preg_match('/(?:apa|prinsip|karakteristik|gelombang|beda|fungsi|jelaskan|frekuensi|amplitudo)/u', $text)) {
            return [
                'answer' => "**Komparasi Akademik: Sinyal Biopotensial Manusia (ECG, EMG, EEG)**\n\n"
                    ."Biopotensial adalah tegangan listrik yang timbul akibat aktivitas elektrokimiawi sel-sel tubuh (khususnya sel saraf dan sel otot) saat terjadi potensial aksi transpor ion \\(\\text{Na}^+, \\text{K}^+, \\text{Ca}^{2+},\\) dan \\(\\text{Cl}^-\\).\n\n"
                    ."| Sinyal | Sumber Organ / Jaringan | Amplitudo Khas | Bandwidth Frekuensi | Signifikansi Klinis & Praktikum |\n"
                    ."| :--- | :--- | :--- | :--- | :--- |\n"
                    ."| **ECG (Elektrokardiogram)** | Aktivitas kelistrikan miokardium jantung | \\(0{,}5 - 4\\text{ mV}\\) | \\(0{,}05 - 100\\text{ Hz}\\) (diagnostik)<br>\\(0{,}5 - 40\\text{ Hz}\\) (monitoring) | Gelombang P (atrium), QRS (ventrikel), T (repolarisasi). |\n"
                    ."| **EMG (Elektromiogram)** | Kontraksi motor unit otot rangka (MUAP) | \\(0{,}1 - 10\\text{ mV}\\) | \\(20 - 500\\text{ Hz}\\) | Sinyal acak/stokastik untuk analisis kelelahan otot & prostesis. |\n"
                    ."| **EEG (Elektroensefalogram)** | Fluktuasi potensial dendritik korteks serebral | \\(10 - 100\\ \\mu\\text{V}\\) | \\(0{,}5 - 50\\text{ Hz}\\) | Ritme Delta (\\(<4\\text{ Hz}\\)), Theta (\\(4-8\\text{ Hz}\\)), Alpha (\\(8-13\\text{ Hz}\\)), Beta (\\(13-30\\text{ Hz}\\)). |\n\n"
                    ."**Tantangan Instrumentasi Pengkondisi Sinyal:**\n"
                    ."1. **Amplitudo Sinyal Sangat Lemah:** Membutuhkan In-Amp gain tinggi (100–10.000 kali) dengan noise sangat rendah.\n"
                    ."2. **Interferensi Mode Bersama (50 Hz):** Tubuh bertindak sebagai antena penerima medan radiasi jala-jala listrik PLN.\n"
                    ."3. **Tegangan Setengah-Sel Elektroda (DC Offset):** Mencapai ratusan mV di antarmuka kulit-elektroda, sehingga memerlukan kopling AC atau High-Pass Filter aktif.",
                'sources' => [
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                    ['title' => 'Evaluasi Praktikum', 'url' => route('evaluasi')],
                ],
            ];
        }

        // 5. RIGHT LEG DRIVE (RLD) & INTERFERENSI NOISE 50 HZ
        if (preg_match('/(?:rld|right\s*leg\s*drive|noise\s*50\s*hz|dengung|interferensi|common\s*mode|cmrr)/u', $text)) {
            return [
                'answer' => "**Kajian Teori: Rangkaian Right Leg Drive (RLD) & Mitigasi Derau 50 Hz**\n\n"
                    ."1. **Permasalahan Fisik (Interferensi Jala-Jala Listrik):**\n"
                    ."Saluran daya AC 220V/50 Hz di sekitar laboratorium menginduksi arus perpindahan (*displacement current* \\(i_{\\text{disp}}\\)) ke tubuh pasien melalui kapasitansi parasit \\(C_{\\text{line}}\\). Arus ini mengalir ke tanah melalui impedansi elektroda dan menimbulkan tegangan mode bersama (\\(V_{cm}\\)) berfrekuensi 50 Hz pada tubuh yang dapat mengaburkan sinyal ECG/EMG.\n\n"
                    ."2. **Prinsip Kerja Right Leg Drive (RLD):**\n"
                    ."Rangkaian RLD tidak menghubungkan kaki kanan secara pasif ke Ground, melainkan secara aktif mengontrol potensial tubuh:\n"
                    ."- Titik tengah resistor pembagi tegangan pada masukan mendeteksi tegangan mode bersama \\(V_{cm}\\).\n"
                    ."- Sinyal \\(V_{cm}\\) dimasukkan ke rangkaian penguat inverting (penguat pembalik dengan penguatan \\(-R_f / R_i\\)).\n"
                    ."- Tegangan pembalik dengan fase berlawanan diinjeksikan kembali ke elektroda kaki kanan (Right Leg).\n"
                    ."- Hal ini menciptakan *negative feedback* loop yang secara virtual menekan tegangan derau mode bersama hingga tereduksi puluhan desibel (dB).\n\n"
                    ."3. **Keuntungan Keselamatan Medis:**\n"
                    ."Jika terjadi kegagalan isolasi atau lonjakan arus dari alat lain, resistor pembatas seri pada output RLD membatasi arus yang masuk ke tubuh di bawah batas aman arus mikro (\\(<10\\ \\mu\\text{A}\\)).",
                'sources' => [
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Jobsheet Penguat AD620', 'url' => route('jobsheet.module', ['edition' => 'panduan-instrumentasi-elektronika-medis-2019', 'module' => 'penguat-ad620'])],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                ],
            ];
        }

        // 6. FILTER AKTIF BIOMEDIS (LPF, HPF, NOTCH)
        if (preg_match('/(?:filter|lpf|hpf|bpf|notch|butterworth|sallen-key|frekuensi\s*cut|cutoff)/u', $text)) {
            return [
                'answer' => "**Kajian Akademik: Filter Aktif pada Instrumentasi Elektronika Medis**\n\n"
                    ."1. **Peran Filter dalam Akuisisi Biosinyal:**\n"
                    ."Sinyal fisiologis selalu bercampur dengan berbagai jenis derau (*noise*). Filter aktif op-amp digunakan untuk membatasi spektrum frekuensi hanya pada pita klinis yang relevan:\n\n"
                    ."| Jenis Filter | Fungsi Spesifik pada Biosinyal | Topologi Umum | Rumus Frekuensi Cut-off (\\(f_c\\)) |\n"
                    ."| :--- | :--- | :--- | :--- |\n"
                    ."| **High-Pass Filter (HPF)** | Memblokir tegangan offset setengah-sel elektroda DC dan *baseline wander* akibat respirasi. | Sallen-Key Orde 1 / Orde 2 | \\(f_c = \\frac{1}{2\\pi RC}\\) |\n"
                    ."| **Low-Pass Filter (LPF)** | Mengeliminasi derau frekuensi radio (RF), sinyal electrosurgical, dan aliasing sebelum ADC. | Butterworth Sallen-Key Orde 2 | \\(f_c = \\frac{1}{2\\pi \\sqrt{R_1 R_2 C_1 C_2}}\\) |\n"
                    ."| **Notch Filter (50 Hz)** | Meredam tajam interferensi frekuensi jala listrik PLN 50 Hz tanpa merusak komponen ECG di sekitarnya. | Twin-T / Bainter Band-Stop | \\(f_0 = \\frac{1}{2\\pi RC} = 50\\text{ Hz}\\) |\n\n"
                    ."2. **Karakteristik Respon Butterworth:**\n"
                    ."Pada praktikum instrumentasi medik, respon **Butterworth** paling umum dipilih karena memiliki karakteristik *maximally flat* (amplitudo datar sempurna tanpa *ripple*) pada pita lewatan (*passband*), sehingga tidak mendistorsi morfologi puncak gelombang biopotensial.",
                'sources' => [
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                    ['title' => 'Evaluasi Praktikum', 'url' => route('evaluasi')],
                ],
            ];
        }

        // 7. KESELAMATAN PASIEN & STANDAR IEC 60601-1 (MICROSHOCK VS MACROSHOCK)
        if (preg_match('/(?:keselamatan|k3|iec\s*60601|microshock|macroshock|arus\s*bocor|isolasi\s*medis|optocoupler)/u', $text)) {
            return [
                'answer' => "**Kajian Keselamatan Kerja & Standar Medis Internasional (IEC 60601-1)**\n\n"
                    ."1. **Fenomena Bahaya Kelistrikan pada Tubuh Manusia:**\n"
                    ."- **Macroshock (Kejutan Makro):** Arus listrik yang mengalir melintasi dua titik kontak pada permukaan kulit luar (misal tangan ke kaki). Kulit kering memiliki impedansi relatif tinggi (\\(10\\text{ k}\\Omega - 100\\text{ k}\\Omega\\)). Ambang persepsi terjadi pada \\(\\approx 1\\text{ mA}\\), *let-go threshold* (sulit melepas) pada \\(10-20\\text{ mA}\\), dan fibrilasi ventrikel fatal pada \\(\\ge 100\\text{ mA}\\).\n"
                    ."- **Microshock (Kejutan Mikro):** Arus listrik yang mengalir **langsung ke miokardium otot jantung** melalui konduktor invasif (misal kateter cairan konduktif atau elektroda pacu jantung). Karena tidak terlindungi oleh resistansi kulit, arus sekecil **\\(10 - 50\\ \\mu\\text{A}\\)** sudah dapat memicu **fibrilasi ventrikel fatal** yang menghentikan denyut jantung!\n\n"
                    ."2. **Klasifikasi Bagian Terapung (*Applied Parts*) Menurut IEC 60601-1:**\n"
                    ."- **Tipe B (Body):** Alat tanpa kontak langsung jantung; batas arus bocor tanah \\(<500\\ \\mu\\text{A}\\).\n"
                    ."- **Tipe BF (Body Floating):** Elektroda menempel pada permukaan tubuh pasien dengan isolasi terapung (contoh: ECG, EMG, PPG); batas arus bocor \\(<100\\ \\mu\\text{A}\\).\n"
                    ."- **Tipe CF (Cardiac Floating):** Kontak invasif langsung ke jantung pasien; batas arus bocor paling ketat yaitu **\\(<10\\ \\mu\\text{A}\\)**.\n\n"
                    ."3. **Teknik Perlindungan Laboratorium:**\n"
                    ."Penggunaan transformator isolasi medis (*isolation transformer*), optocoupler (isolasi optik), penguat isolasi (*isolation amplifier*), dan kepatuhan grounding laboratoris sesuai SOP K3 UNY.",
                'sources' => [
                    ['title' => 'Evaluasi Praktikum', 'url' => route('evaluasi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                ],
            ];
        }

        // 8. ELEKTRODA BIOPOTENSIAL (AG/AGCL)
        if (preg_match('/(?:elektroda|ag\/agcl|silver\s*chloride|gel\s*elektrolit|polarisasi|half\s*cell)/u', $text)) {
            return [
                'answer' => "**Kajian Teori: Elektroda Biopotensial Ag/AgCl & Antarmuka Elektrolit-Kulit**\n\n"
                    ."1. **Transduksi Sinyal Ionik ke Elektronik:**\n"
                    ."Di dalam tubuh manusia, pembawa muatan listrik adalah ion (\\(\\text{Na}^+, \\text{K}^+, \\text{Cl}^-\\)), sedangkan pada rangkaian elektronik adalah elektron (\\(e^-\\)). Elektroda biopotensial bertindak sebagai transduser elektrokimiawi yang mengubah arus ionik menjadi arus elektronik melalui reaksi reduksi-oksidasi:\n"
                    ."\\[ \\text{Ag} + \\text{Cl}^- \\rightleftharpoons \\text{AgCl} + e^- \\]\n\n"
                    ."2. **Mengapa Elektroda Ag/AgCl Menjadi Standar Emas:**\n"
                    ."- **Non-Polarizable (Tahan Polarisasi):** Memungkinkan arus bolak-balik melintasi antarmuka elektroda tanpa menimbulkan overpotensial polarisasi yang signifikan.\n"
                    ."- **Tegangan Setengah-Sel Rendah & Stabil:** Memiliki potensial kontak relatif stabil (~+0,222 V terhadap standar hidrogen), meminimalkan *drift baseline* pada osiloskop.\n"
                    ."- **Tingkat Noise Rendah:** Memiliki tegangan derau intrinsik sangat rendah dibandingkan elektroda logam murni (seperti tembaga atau perak polos).\n\n"
                    ."3. **Peran Gel Elektrolit & Preparasi Kulit:**\n"
                    ."Lapisan tanduk kulit (*stratum corneum*) memiliki resistansi listrik tinggi dan bersifat dielektrik. Penggunaan gel elektrolit yang mengandung ion klorida (\\(\\text{Cl}^-\\)) serta pembersihan minyak kulit dengan alkohol berfungsi menjamin impedansi kontak rendah (\\(<5\\text{ k}\\Omega\\)) untuk sinyal yang jernih.",
                'sources' => [
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                ],
            ];
        }

        // 9. METODOLOGI & FORMAT LAPORAN PRAKTIKUM AKADEMIK
        if (preg_match('/(?:laporan|format\s*laporan|analisis\s*teknis|sistematika|penulisan|laporan\s*praktikum)/u', $text)
            && ! preg_match('/(?:maksimum|batas|ukuran|unggah|upload)/u', $text)) {
            return [
                'answer' => "**Panduan Akademik: Sistematika Penulisan Laporan Praktikum Elektronika Medis**\n\n"
                    ."Laporan praktikum disusun secara ilmiah dan terstruktur untuk mempertanggungjawabkan hasil eksperimen laboratoris. Sistematika baku laporan meliputi:\n\n"
                    ."1. **Identitas & Judul Percobaan:** Nama mahasiswa, NIM, kelas, kelompok, tanggal praktikum, dan judul modul jobsheet.\n"
                    ."2. **Tujuan Praktikum:** Pernyataan capaian kompetensi terukur berdasarkan RPS dan indikator modul.\n"
                    ."3. **Landasan Teori:** Penjelasan konsep fisik, diagram blok, dan formulasi matematis acuan (misal: penurunan gain AD620, frekuensi cutoff filter, atau hukum optik PPG).\n"
                    ."4. **Alat & Bahan:** Daftar instrumen laboratorium beserta spesifikasi dan nomor seri (misal: Osiloskop Digital 100 MHz, Function Generator, Power Supply Dual $\\pm12$V, IC AD620, Sensor PPG).\n"
                    ."5. **Langkah Kerja & Skema Rangkaian:** Gambar skematik rangkaian dan diagram alir prosedur uji.\n"
                    ."6. **Data Hasil Pengukuran:** Tabel pencatatan nilai terukur, tangkapan osiloskop (*waveform screenshots*), dan visualisasi grafik.\n"
                    ."7. **Analisis Data & Pembahasan Komparatif:**\n"
                    ."   - Membandingkan hasil kalkulasi teoritis vs hasil pengukuran laboratorium.\n"
                    ."   - Menghitung persentase galat (error):\n"
                    ."     \\[ \\%\\text{ Error} = \\left| \\frac{\\text{Nilai Ukur} - \\text{Nilai Teori}}{\\text{Nilai Teori}} \\right| \\times 100\\% \\]\n"
                    ."   - Membahas faktor penyebab deviasi (toleransi komponen resistor/kapasitor, noise jala-jala listrik, impedansi probe osiloskop).\n"
                    ."8. **Kesimpulan & Refleksi:** Menjawab tujuan praktikum secara lugas dan mencantumkan refleksi perbaikan eksperimen berikutnya.\n"
                    ."9. **Daftar Pustaka:** Format rujukan baku (IEEE / APA).\n\n"
                    ."*Ketentuan Berkas:* Laporan dikonversi ke format PDF (maksimal 10 MB) dan diunggah pada menu **Unggah Laporan** setelah masuk ke akun mahasiswa.",
                'sources' => [
                    ['title' => 'Unggah Laporan', 'url' => route('laporan')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                    ['title' => 'Evaluasi Praktikum', 'url' => route('evaluasi')],
                ],
            ];
        }

        // 10. INSTRUMEN LABORATORIUM: OSILOSKOP & KALIBRASI
        if (preg_match('/(?:osiloskop|probe|kalibrasi|coupling|generator\s*fungsi|catu\s*daya)/u', $text)) {
            return [
                'answer' => "**Panduan Teknis Laboratorium: Penggunaan & Kalibrasi Osiloskop pada Sinyal Biomedis**\n\n"
                    ."1. **Pemilihan Mode Kopling Input (Input Coupling):**\n"
                    ."- **DC Coupling:** Menampilkan seluruh komponen tegangan (tegangan searah DC + tegangan bolak-balik AC). Wajib digunakan saat mengukur tegangan suplai IC atau tegangan offset elektroda.\n"
                    ."- **AC Coupling:** Menghubungkan kapasitor seri internal untuk memblokir komponen DC. Sangat berguna untuk mengamati sinyal biopotensial beramplitudo kecil (milivolt) yang menumpang di atas tegangan offset DC besar tanpa menyebabkan osiloskop terkliping.\n\n"
                    ."2. **Kompensasi Frekuensi Probe (Aturan 1X vs 10X):**\n"
                    ."- **Probe 1X:** Impedansi input \\(1\\text{ M}\\Omega \\parallel 100\\text{ pF}\\). Rentan membebani rangkaian berimpedansi tinggi dan memiliki bandwidth terbatas (~6–10 MHz).\n"
                    ."- **Probe 10X:** Menghubungkan attenuator resistor \\(9\\text{ M}\\Omega\\) seri sehingga total impedansi masukan menjadi **\\(10\\text{ M}\\Omega\\)** dengan kapasitansi hanya ~10–15 pF. Hal ini meminimalkan *circuit loading*.\n"
                    ."- *Kalibrasi Probe:* Hubungkan probe 10X ke terminal referensi gelombang kotak (biasanya 1 kHz / 2 Vpp). Putar sekrup trimmer pada probe hingga sudut gelombang kotak tepat siku (90°), tidak *under-compensated* (membulat) maupun *over-compensated* (overshoot lancip).\n\n"
                    ."3. **Penyetelan Sensitivitas & Pemicu (Triggering):**\n"
                    ."Atur *Volts/Div* dan *Time/Div* agar satu siklus gelombang terlihat jelas memenuhi 60–80% layar tampilan osiloskop.",
                'sources' => [
                    ['title' => 'Materi Praktikum', 'url' => route('materi')],
                    ['title' => 'Praktikum & Jobsheet', 'url' => route('praktikum')],
                ],
            ];
        }

        return null;
    }

    /**
     * Professional, academic greeting responses with topical prompts.
     */
    public function greeting(string $normalized): ?string
    {
        $greetings = [
            'assalamualaikum' => "Wa'alaikumussalam warahmatullahi wabarakatuh. Selamat datang di portal Praktik Elektronika Medis. Ada materi, jobsheet, atau prosedur praktikum yang dapat saya bantu diskusikan secara akademik?",
            'pagi' => 'Selamat pagi! Saya Asisten Praktik Elektronika Medis. Ada yang bisa saya bantu terkait materi, penguat instrumentasi, atau jobsheet praktikum?',
            'siang' => 'Selamat siang! Saya Asisten Praktik Elektronika Medis. Ada yang bisa saya bantu terkait materi, praktikum, atau laporan hari ini?',
            'sore' => 'Selamat sore! Saya Asisten Praktik Elektronika Medis. Ada yang bisa saya bantu terkait materi pembelajaran atau evaluasi praktikum?',
            'malam' => 'Selamat malam! Saya Asisten Praktik Elektronika Medis. Ada yang bisa saya bantu terkait persiapan praktikum atau analisis jobsheet?',
            'permisi' => 'Halo, silakan! Saya siap membantu menjawab pertanyaan seputar materi Praktik Elektronika Medis, mulai dari konsep sensor biopotensial, penguat instrumentasi, filter aktif, hingga keselamatan K3.',
            'tes' => 'Sistem Asisten Pembelajaran Praktik Elektronika Medis aktif dan responsif. Silakan ajukan pertanyaan terkait materi, kalkulasi AD620, atau jobsheet.',
            'ping' => 'Pong! Sistem asisten lokal berjalan optimal. Silakan tanyakan konsep elektronika medis atau prosedur praktikum yang ingin Anda pelajari.',
            'bantu saya' => 'Tentu, dengan senang hati. Anda dapat menanyakan topik seperti prinsip kerja AD620, cara membaca BPM via BLE smartwatch, perbedaan sinyal ECG/EMG/EEG, mitigasi noise 50 Hz, hingga sistematika penyusunan laporan praktikum.',
            'apa saja fitur website ini' => "Website Praktik Elektronika Medis menyediakan berbagai media pembelajaran terintegrasi:\n1. **Materi Pembelajaran:** Konsep biosinyal, pengkondisi sinyal, dan keselamatan K3 medis.\n2. **Katalog 14 Jobsheet:** Rujukan modul praktikum resmi berbasis RPS.\n3. **Monitor Trainer (BLE):** Simulasi dan pembacaan detak jantung nyata dari smartwatch via Bluetooth Low Energy.\n4. **Evaluasi & Latihan Mandiri:** Bank soal latihan 14 modul jobsheet.\n5. **Unggah Laporan:** Pengumpulan berkas PDF laporan praktikum ke dosen.\n6. **Asisten AI:** Tutor cerdas lokal untuk berdiskusi materi akademik dan menghitung rangkaian.",
            'bagaimana cara menggunakan website ini' => "Untuk memulai pembelajaran:\n1. Pelajari panduan dan capaian di menu **Materi**.\n2. Buka menu **Praktikum**, pilih topik jobsheet yang dijadwalkan, lalu pelajari prosedur dan skema rangkaiannya.\n3. Gunakan menu **Monitor Trainer (BLE)** untuk mengamati sinyal detak jantung.\n4. Uji pemahaman melalui menu **Evaluasi**.\n5. Setelah praktikum selesai, susun laporan PDF dan kirimkan melalui menu **Unggah Laporan**.",
            'apa itu praktikum elektronika medis' => 'Praktik Elektronika Medis adalah mata kuliah laboratorium berbobot 2 SKS pada Program Studi Pendidikan Teknik Elektronika UNY. Praktikum ini membekali mahasiswa dengan kompetensi perancangan, pengukuran, analisis, dan keselamatan instrumentasi elektronika yang diaplikasikan pada sinyal fisiologis tubuh manusia.',
            'apa saja modul jobsheetnya' => 'Praktikum ini mencakup 14 topik jobsheet berurutan, mulai dari Penguat AD620, Elektroda ECG, Penguat Biopotensial, Right Leg Drive, Filter Aktif LPF/HPF/BPF/Notch 50 Hz, Rangkaian Isolasi Pasien, hingga sistem akuisisi detak jantung optik (PPG).',
            'terima kasih' => 'Sama-sama! Senang dapat membantu. Semoga praktikum Anda lancar, aman, dan membuahkan hasil akademik yang memuaskan.',
            'makasih' => 'Sama-sama! Selamat belajar dan sukses untuk kegiatan praktikumnya.',
            'thank you' => 'You are welcome! Tetap semangat dalam mempelajari instrumentasi dan elektronika medis.',
            'thanks' => 'Sama-sama! Sukses selalu dalam kegiatan perkuliahan dan praktikum.',
            'oke' => 'Baik! Jika ada materi lain yang ingin didiskusikan, silakan tuliskan pertanyaan Anda kapan saja.',
            'siap' => 'Bagus sekali! Silakan manfaatkan asisten ini untuk memperdalam pemahaman sebelum dan sesudah praktikum.',
            'keren' => 'Terima kasih atas apresiasinya! Sistem asisten ini terus dikembangkan untuk mendukung pembelajaran mandiri mahasiswa.',
        ];

        return $greetings[$normalized] ?? null;
    }
}
