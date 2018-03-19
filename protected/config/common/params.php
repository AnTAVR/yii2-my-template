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
    'meta_url_pattern' => '/^[a-z1-9\-]*$/s',
    'meta_url_hint' => 'a-z 0-9 -',
    'theme' => 'app\themes\BasicTheme',
];
