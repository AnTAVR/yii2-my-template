<?php
return [
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
