<?php
$params = require __DIR__ . '/common/params.php';
$test_db = require __DIR__ . '/test_db.php';

$config = [
    'language' => 'en-US', //+
    'id' => 'basic-tests', //+
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
        ],
        'db' => $test_db,
    ],
    'params' => $params,
];

/**
 * Application configuration shared by all test types
 */
return $config;
