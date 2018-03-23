<?php
return [
    'duration' => 60 * 60 * 24 * 30,
    'signup' => true, // Разрешить регистрацию на сайте.
    'adminPageSize' => 100,
    'expires_confirm_email' => 60 * 60 * 24,
    'expires_recovery_password' => 60 * 60 * 24,
    'username.max' => 16,
    'username.min' => 2,
    'username.pattern' => '/^[A-Za-z1-9\-_]+$/s',
    'username.hint' => 'A-Z a-z 0-9 -_',
    'password.min' => 6,
    'password.max' => 128,
];
