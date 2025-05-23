
<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function() {
    Flight::route('POST /register', function () {
        $data = Flight::request()->data->getData();
        $res = Flight::auth_service()->register($data);
        if ($res['success']) {
            Flight::json(['message' => 'Registered successfully', 'data' => $res['data']]);
        } else {
            Flight::halt(500, $res['error']);
        }
    });

    Flight::route('POST /login', function () {
        $data = Flight::request()->data->getData();
        $res = Flight::auth_service()->login($data);
        if ($res['success']) {
            Flight::json(['message' => 'Login successful', 'data' => $res['data']]);
        } else {
            Flight::halt(500, $res['error']);
        }
    });
});
