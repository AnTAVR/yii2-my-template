<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/common/params.php';

Yii::setAlias('@webroot', dirname(dirname(__DIR__)));
Yii::setAlias('@web', '/');
Yii::setAlias('@tests', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests');

/** @noinspection HtmlUnknownTag */
$__config = [
    'language' => YII_ENV_TEST ? 'en-US' : $params['language'],
    'name' => $params['appName'],
    'id' => 'common',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ArrayHelper::merge(['log'], array_keys(require __DIR__ . '/common/modules.php')),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@backups' => '@app/backups',
        '@upload_path' => '@webroot/upload',
        '@upload_web' => '@web/upload',
    ],
    'container' => [
        'definitions' => [
            'yii\web\Session' => [
                'class' => 'app\components\Session',
//                 @todo: Из за установки не работают тесты!!!
//                'savePath' => '@runtime/session',
            ],
//            'yii\grid\ActionColumn' => [
//                'class' => 'app\components\ActionColumn',
//            ],
        ],
        'singletons' => [
        ],
    ],
    'modules' => require __DIR__ . '/common/modules.php',

    'components' => [
        'formatter' => [
            'datetimeFormat' => 'Y-MM-dd HH:mm:ss',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'to' => $params['adminEmail'],
                        'from' => $params['supportEmail'],
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                ],
                'test' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                ],
            ]
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap-theme.css' : 'css/bootstrap-theme.min.css',
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => YII_ENV_TEST,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host={$params['db.host']};dbname={$params['db.dbname']}" . (YII_ENV_TEST ? '_tests' : ''),
            'username' => $params['db.username'],
            'password' => $params['db.password'],
            'charset' => 'utf8',
            'enableSchemaCache' => !YII_ENV_DEV,
        ],
        'view' => [
            'theme' => $params['theme'],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\account\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/site/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'defaultRoles' => ['users-role'],
            'cache' => YII_ENV_DEV ? null : 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $__config['bootstrap'][] = 'gii';
    $__config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

if (YII_DEBUG && !YII_ENV_TEST) {
    $__config['bootstrap'][] = 'debug';
    $__config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $__config;
