<x-layouts.platform title="Materi | Praktik Elektronika Medis">
<section class="page-hero">
    <p class="eyebrow">Materi pembelajaran</p>
    <h1>Materi Praktikum</h1>
    <p>Ringkasan kelompok topik Elektronika Medis sebagai pengantar sebelum membuka jobsheet praktikum dan mengerjakan latihan soal mandiri.</p>
</section>

<section class="page-content">
    <div class="ai-boundary">
        <strong>Referensi sumber pembelajaran</strong>
        Kelompok materi di bawah merujuk pada Panduan Praktikum Instrumentasi &amp; Elektronika Medis (2019) serta modul simulasi Heart Rate / PPG. Gunakan bersama arahan dosen pengampu.
    </div>

    <div class="content-grid">
        <article class="content-card">
            <span>01 · Penguat Sinyal</span>
            <h2>Penguat Instrumentasi, AD620 &amp; Adder</h2>
            <p>Prinsip penguatan sinyal biopotensial beramplitudo milivolt (mV), impedansi masukan tinggi, CMRR untuk menekan derau 50 Hz, persamaan AD620, dan penggeser level DC sebelum ADC.</p>
            <p style="margin-top:14px"><a class="button text-button" href="{{ route('praktikum') }}#jobsheet">Buka Jobsheet 1–3 <span>→</span></a></p>
        </article>

        <article class="content-card">
            <span>02 · Filter Aktif</span>
            <h2>LPF, HPF, Butterworth, BPF &amp; Notch Filter</h2>
            <p>Perancangan filter aktif orde 1 hingga orde 3 (VCVS Sallen-Key dan ragam umpan balik), band pass filter, serta Twin-T notch filter untuk menapis gangguan jala-jala listrik 50 Hz.</p>
            <p style="margin-top:14px"><a class="button text-button" href="{{ route('praktikum') }}#jobsheet">Buka Jobsheet 4–10 <span>→</span></a></p>
        </article>

        <article class="content-card">
            <span>03 · Aplikasi Biomedis</span>
            <h2>Plethysmograph, Termometer LM35, ECG &amp; EMG</h2>
            <p>Penerapan sensor optik LED-LDR dengan Arduino, sensor suhu linear LM35 (10 mV/°C), perekaman sinyal jantung ECG (0,05–100 Hz), dan aktivitas kontraksi otot EMG (50 µV–5 mV).</p>
            <p style="margin-top:14px"><a class="button text-button" href="{{ route('evaluasi') }}#latihan-jobsheet">Latihan Soal 14 Modul <span>→</span></a></p>
        </article>

        <article class="content-card">
            <span>Pilot · PPG</span>
            <h2>Pengantar Heart Rate / PPG</h2>
            <p>Materi pengantar prinsip sensor optik, BPM, artefak sinyal, pre-lab, dan jobsheet simulasi tersedia sebagai draf pilot yang belum divalidasi dosen.</p>
            <p style="margin-top:14px"><a class="button text-button" href="{{ route('pilot.heart-rate') }}#pilot-learning">Pelajari modul pilot <span>→</span></a></p>
        </article>
    </div>
</section>
</x-layouts.platform>
