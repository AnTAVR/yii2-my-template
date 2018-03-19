<?php
$params = require __DIR__ . '/common/params.php';
$db = require __DIR__ . '/test_db.php';
$modules = require __DIR__ . '/common/modules.php';
$container = require __DIR__ . '/container.php';
$assetManager = require __DIR__ . '/assetManager.php';
$aliases = require __DIR__ . '/common/aliases.php';

$config = [
    'language' => 'en-US', //+
    'id' => 'basic-tests', //+
    'bootstrap' => array_merge(['log'],  array_keys($modules)),
    'components' => [
        'request' => [
            'cookieValidationKey' => 'test',
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
        'view' => [
            'class' => 'app\components\View',
            'theme' => $params['theme'],
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/account/login'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/static/<meta_url>' => '/static/index',
            ],
        ],
        'assetManager' => $assetManager,
        'db' => $db,
    ],
    'aliases' => $aliases,
    'container' => $container,
    'modules' => $modules,
    'params' => $params,
];

/**
 * Application configuration shared by all test types
 */
return $config;
