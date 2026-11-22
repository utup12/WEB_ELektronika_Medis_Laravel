<?php

test('legacy local student profile route is removed in favor of authenticated login', function () {
    $this->get('/profil-mahasiswa')->assertNotFound();
    $this->get('/masuk')->assertOk();
    $this->get('/daftar')->assertOk();
});

test('home page loads shared navigation bootstrap script', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('/js/script.js');

    $script = file_get_contents(public_path('js/student-profile.js'));
    expect($script)->toContain('alur Masuk');
});
