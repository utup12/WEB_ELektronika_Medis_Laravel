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
