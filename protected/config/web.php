<?php
$params = require __DIR__ . '/common/params.php';
$db = require __DIR__ . '/db.php';

/** @noinspection HtmlUnknownTag */
$config = [
    'id' => 'basic', //+
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jXBjnr3BwJb-0lXBx8fZfYKKGdqkXb-X',
            'csrfParam' => 'ckCsrfToken',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
        ],
        'session' => [
            'class' => 'app\components\Session',
            'savePath' => '@runtime/session',
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
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
        'db' => $db,
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
