<?php
$domen = 'localhost.localhost';

return [
    'brandLabel' => 'brandLabel',
    'brandLabelText' => 'brandLabelText<br>brandLabelText',
    'appName' => $domen,
    'adminEmail' => 'info@' . $domen,
    'supportEmail' => 'robot@' . $domen,
    'language' => 'ru',
    'string.max' => 255,
    'user.passwordResetTokenExpire' => 60 * 60,
    'password.min' => 6,
    'username.max' => 16,
    'username.min' => 2,
    'email.max' => 128,
    'login.duration' => 60 * 60 * 24 * 30,
    'contact.name.max' => 255,
    'contact.subject.max' => 255,
    'contact.body.max' => 3000,
    'meta_url_pattern' => '/^[a-z1-9\-]*$/s',
    'meta_url_hint' => 'a-z 0-9 -',
    'theme' => 'app\themes\BasicTheme',
];
