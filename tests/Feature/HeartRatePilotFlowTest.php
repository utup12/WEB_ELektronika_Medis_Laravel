<?php

test('candidate heart rate pilot page renders the end to end scaffold', function () {
    $response = $this->get(route('pilot.heart-rate'));

    $response->assertOk();
    $response->assertSee('Candidate pilot');
    $response->assertSee('Heart Rate / PPG');
    $response->assertSee('belum modul resmi');
    $response->assertSee('Materi');
    $response->assertSee('Pre-lab');
    $response->assertSee('Jobsheet');
    $response->assertSee('Praktikum');
    $response->assertSee('Monitor Trainer');
    $response->assertSee('Interpretasi');
    $response->assertSee('Refleksi');
    $response->assertSee('Laporan');
});

test('candidate heart rate pilot links to existing learning stages', function () {
    $response = $this->get(route('pilot.heart-rate'));

    $response->assertOk();
    $response->assertSee(route('materi'), false);
    $response->assertSee(route('evaluasi'), false);
    $response->assertSee(route('jobsheet'), false);
    $response->assertSee(route('praktikum'), false);
    $response->assertSee(route('monitor-trainer'), false);
    $response->assertSee(route('laporan'), false);
});

test('praktikum page exposes the candidate pilot entry point', function () {
    $response = $this->get(route('praktikum'));

    $response->assertOk();
    $response->assertSee('Candidate pilot');
    $response->assertSee(route('pilot.heart-rate'), false);
});

test('pilot includes a complete preliminary learning and simulation workflow', function () {
    $response = $this->get(route('pilot.heart-rate'));

    $response->assertOk();
    $response->assertSee('Dasar PPG dan pengukuran heart rate');
    $response->assertSee('Pre-lab: cek pemahaman mandiri');
    $response->assertSee('id="pilot-prelab"', false);
    $response->assertSee('id="pilot-prelab-result"', false);
    $response->assertSee('Jobsheet pilot');
    $response->assertSee('Format pengamatan');
    $response->assertSee('Evaluasi formatif');
    $response->assertSee('pilot-heart-rate-reflection-v1');
    $response->assertSee('belum modul resmi');
});

test('main learning pages and pilot route respond successfully', function () {
    foreach ([
        'home', 'materi', 'jobsheet', 'praktikum',
        'panduan-praktikum', 'evaluasi', 'laporan',
        'monitor-trainer', 'profil-mahasiswa', 'profil-dosen',
        'tentang', 'pilot.heart-rate',
    ] as $name) {
        $this->get(route($name))->assertOk();
    }
});

test('materi and evaluasi link directly to the PPG learning section', function () {
    foreach (['materi', 'evaluasi'] as $page) {
        $this->get(route($page))
            ->assertOk()
            ->assertSee(route('pilot.heart-rate').'#pilot-learning', false);
    }
});

test('pilot provides local-only draft controls and no automatic clinical claims', function () {
    $this->get(route('pilot.heart-rate'))
        ->assertOk()
        ->assertSee('Simulasi')
        ->assertSee('pilot-save')
        ->assertSee('pilot-export')
        ->assertSee('pilot-clear')
        ->assertSee('bukan pengukuran pasien');
});

test('jobsheet catalog links to the PPG pilot procedure', function () {
    $this->get(route('jobsheet'))
        ->assertOk()
        ->assertSee('Kandidat pilot')
        ->assertSee(route('pilot.heart-rate').'#pilot-learning', false);
});

test('report page clearly distinguishes local pilot notes from server upload', function () {
    $this->get(route('laporan'))
        ->assertOk()
        ->assertSee('tidak mengirim berkas ke dosen atau server')
        ->assertSee(route('pilot.heart-rate').'#pilot-reflection-form', false);
});
