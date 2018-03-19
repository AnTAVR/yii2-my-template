<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/common/params.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';
$modules = require __DIR__ . '/common/modules.php';
$container = require __DIR__ . '/container.php';
$assetManager = require __DIR__ . '/assetManager.php';
$aliases = require __DIR__ . '/common/aliases.php';

/** @noinspection HtmlUnknownTag */
$config = [
    'language' => $params['language'],
    'name' => $params['appName'],
    'id' => 'common',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ArrayHelper::merge(['log'], array_keys($modules)),
    'aliases' => $aliases,
    'container' => $container,
    'modules' => $modules,

    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => $i18n,
        'assetManager' => $assetManager,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/static/<meta_url>' => '/static/index',
            ],
        ],
        'db' => $db,
        'view' => [
            'theme' => $params['theme'],
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/account/login'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
