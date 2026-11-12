<?php

test('home page static files and navigation use current origin on preview', function () {
    config()->set('app.url', 'https://production.example.test');

    $this->withServerVariables([
        'HTTP_HOST' => 'preview.example.test',
        'HTTPS' => 'on',
    ])->get('/')
        ->assertOk()
        ->assertSee('href="/css/styles.css"', false)
        ->assertSee('href="/css/identity.css"', false)
        ->assertSee('href="/css/visual-enhancements.css"', false)
        ->assertSee('src="/assets/logo-uny.png"', false)
        ->assertSee('src="/js/navigation.js"', false)
        ->assertSee('src="/js/script.js"', false)
        ->assertSee('href="/asisten-ai"', false)
        ->assertDontSee('src="https://production.example.test', false)
        ->assertDontSee('href="https://production.example.test/css/', false);
});
