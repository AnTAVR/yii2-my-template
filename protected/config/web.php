<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';
$modules = require __DIR__ . '/modules.php';

/** @noinspection HtmlUnknownTag */
$config = [
    'language' => $params['language'],
    'name' => $params['appName'],
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'] + array_keys($modules),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jXBjnr3BwJb-0lXBx8fZfYKKGdqkXb-X',
            'csrfParam' => 'ckCsrfToken',
        ],
        'session' => [
            'class' => 'app\components\Session',
            'savePath' => '@runtime/session',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'class' => 'yii\web\View',
            'theme' => $params['theme'],
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/user/default/login'
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => $i18n,
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/static/<meta_url>' => '/static/index',
            ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
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
    ],
    'modules' => $modules,
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
