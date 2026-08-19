<?php

test('landing page shows registrar login button', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Registrar Login');
});

test('admin login page shows school registrar portal', function () {
    $response = $this->get('/auth/admin-login');

    $response->assertOk();
    $response->assertSee('School Registrar');
});
