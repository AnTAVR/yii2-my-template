<?php
$params = require __DIR__ . '/common/params.php';

/** @noinspection HtmlUnknownTag */
$__config = [
    'components' => [
        'request' => [
            'csrfParam' => 'ckCsrfToken',
            'enableCsrfValidation' => !YII_ENV_TEST,
        ],
        'view' => [
            'theme' => $params['theme'],
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
    ],
];

return $__config;
