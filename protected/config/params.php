<?php
$domen = 'localhost.localhost';

return [
    'brandLabel' => 'brandLabel',
    'brandLabelText' => 'brandLabelText<br>brandLabelText',
    'appName' => $domen,
    'adminEmail' => 'info@' . $domen,
    'supportEmail' => 'robot@' . $domen,
    'language' => 'ru',
    'user.passwordResetTokenExpire' => 60 * 60,
    'password.min' => 6,
    'password.max' => 128,
    'username.max' => 16,
    'username.min' => 2,
    'username.pattern' => '/^[A-Za-z1-9\-_]+$/s',
    'username.hint' => 'A-Z a-z 0-9 -_',
    'string.max' => 255,
    'email.max' => 128,
    'login.duration' => 60 * 60 * 24 * 30,
    'contact.body.max' => 3000,
    'meta_url_pattern' => '/^[a-z1-9\-]*$/s',
    'meta_url_hint' => 'a-z 0-9 -',
    'theme' => 'app\themes\BasicTheme',
];
