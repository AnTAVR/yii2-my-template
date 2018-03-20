<?php
$params = require __DIR__ . '/common/params.php';

/** @noinspection HtmlUnknownTag */
$__config = [
    'components' => [
        'request' => [
            'csrfParam' => 'ckCsrfToken',
            'enableCsrfValidation' => !YII_ENV_TEST,
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
    ],
];

return $__config;
