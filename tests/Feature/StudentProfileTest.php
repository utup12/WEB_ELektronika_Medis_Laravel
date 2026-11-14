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

test('profile button supports an in-page dialog across website pages', function () {
    $script = file_get_contents(public_path('js/student-profile.js'));

    expect($script)->toContain('showProfileDialog(link)')
        ->toContain('aria-modal')
        ->toContain("frame.src = '/profil-mahasiswa'")
        ->toContain('closeDialog');

    foreach (['/', '/asisten-ai', '/jobsheet'] as $path) {
        $this->get($path)
            ->assertOk()
            ->assertSee('/js/script.js');
    }
});

test('student profile appears above course title without relocating menu', function () {
    $script = file_get_contents(public_path('js/student-profile.js'));
    $styles = file_get_contents(public_path('css/student-profile.css'));

    expect($script)->toContain("bar.querySelector('.header-tools')")
        ->toContain("tools?.querySelector('.course-brand')")
        ->toContain('stack.prepend(link)')
        ->toContain('stack.append(brand)')
        ->not->toContain('bar.append(link);\n        // Open the locally stored profile');

    expect($styles)->toContain('.student-profile-course-stack')
        ->toContain('align-items: flex-end')
        ->toContain('flex-direction: column');

    $this->get('/')->assertOk()->assertSee('class="nav-dropdown"', false);
});
