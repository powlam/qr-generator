<?php

declare(strict_types=1);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('generates a QR from the web', function () {
    $response = $this->post('/', ['linkToConvert' => 'http://google.com', 'qrColor' => '#ff2288', 'qrType' => 'square']);

    $response
        ->assertOk()
        ->assertSee('data:image/png;base64');
});
