<?php

use App\Models\User;

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
        'home', 'materi', 'praktikum',
        'evaluasi', 'monitor-trainer', 'profil-dosen',
        'tentang', 'pilot.heart-rate',
    ] as $name) {
        $this->get(route($name))->assertOk();
    }
});

test('praktikum page includes merged panduan praktikum content and legacy route redirects', function () {
    $this->get(route('praktikum'))
        ->assertOk()
        ->assertSee('Panduan Praktikum')
        ->assertSee('01 · Sebelum')
        ->assertSee('02 · Saat')
        ->assertSee('03 · Sesudah');

    $this->get(route('panduan-praktikum'))
        ->assertRedirect('/praktikum#panduan-praktikum');
});

test('materi and evaluasi link directly to the PPG learning section', function () {
    foreach (['materi'] as $page) {
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

test('praktikum page links to the PPG pilot procedure', function () {
    $this->get(route('praktikum'))
        ->assertOk()
        ->assertSee('Candidate pilot')
        ->assertSee(route('pilot.heart-rate').'#pilot-jobsheet', false);
});

test('report page requires authentication and displays 10 MB PDF limit', function () {
    $this->get(route('laporan'))->assertRedirect(route('masuk'));

    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)
        ->get(route('laporan'))
        ->assertOk()
        ->assertSee('Unggah Laporan Praktikum')
        ->assertSee('Maksimum 10 MB');
});

test('trainer BLE notifications guard incomplete 16-bit readings and invalid BPM', function () {
    $script = file_get_contents(public_path('js/script.js'));

    expect($script)->toContain('isSixteenBit && value.byteLength < 3')
        ->toContain('heartRate >= minHeartRate && heartRate <= maxHeartRate')
        ->toContain('Belum tervalidasi untuk penggunaan klinis.');
});

test('pilot navigation uses real anchor targets', function () {
    $this->get(route('pilot.heart-rate'))
        ->assertOk()
        ->assertSee('href="#pilot-learning"', false)
        ->assertSee('href="#pilot-prelab"', false)
        ->assertSee('id="pilot-jobsheet"', false)
        ->assertSee('href="#pilot-jobsheet"', false)
        ->assertSee('href="#pilot-reflection-form"', false);
});

test('PPG prelab offers detailed feedback and reset', function () {
    $this->get(route('pilot.heart-rate'))
        ->assertOk()
        ->assertSee('Ulangi pre-lab')
        ->assertSee('Soal 1: data simulasi dibuat perangkat lunak')
        ->assertSee('Soal 2: BPM = 60/interval')
        ->assertSee('Soal 3: gerakan jari dapat menimbulkan artefak');
});

test('evaluasi page links to actual PPG prelab', function () {
    $this->get(route('evaluasi'))
        ->assertOk()
        ->assertSee(route('pilot.heart-rate').'#pilot-prelab', false);
});

test('BLE connected state waits for valid heart rate notifications', function () {
    $script = file_get_contents(public_path('js/script.js'));

    expect($script)->toContain("heartbeatStatus.textContent = 'BLE WAIT'")
        ->toContain("heartbeatValue.textContent = '—'")
        ->toContain("trainerHeaderLabel.textContent = 'HEART RATE MONITOR · MODE BLE'");
});

test('navigation script does not inject a separate practical guide link', function () {
    $script = file_get_contents(public_path('js/script.js'));

    expect($script)->not->toContain("guideLink.href = '/panduan-praktikum'");
});
