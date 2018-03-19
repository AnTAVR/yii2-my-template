<?php

use yii\helpers\ArrayHelper;

$test_db = require __DIR__ . '/test_db.php';

$config = [
    'language' => 'en-US',
    'id' => 'basic-tests',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'test',
            'csrfParam' => 'ckCsrfToken',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'db' => $test_db,
    ],
];

return ArrayHelper::merge(require __DIR__ . '/common.php', $config);
