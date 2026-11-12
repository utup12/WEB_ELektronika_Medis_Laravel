<?php

test('student profile page supports local-only name nim and photo input', function () {
    $this->get(route('profil-mahasiswa'))
        ->assertOk()
        ->assertSee('Profil Mahasiswa')
        ->assertSee('name="student_name"', false)
        ->assertSee('name="student_nim"', false)
        ->assertSee('name="student_photo"', false)
        ->assertSee('Hapus Profil Lokal')
        ->assertSee('bukan login akademik terverifikasi');
});

test('home page has shared client-side profile navigation bootstrap', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('/js/script.js');
});

test('profile page route does not create a server login', function () {
    $this->get('/profil-mahasiswa')->assertOk();
    $this->get('/profil-mahasiswa/logout')->assertNotFound();
});
