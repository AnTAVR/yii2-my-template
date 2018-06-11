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
    'email.max' => 128,
    'contact.body.max' => 3000,
    'meta_url_pattern' => '/^[a-z0-9\-]*$/s',
    'meta_url_hint' => 'a-z 0-9 -',
    'theme' => 'app\themes\BasicTheme',
    'db.host' => '127.0.0.1',
    'db.dbname' => 'tests',
    'db.username' => 'tests',
    'db.password' => 'teststests',
    'phone.countries' => ['ru', 'ua'],
    'icon-framework' => 'fa',
];
