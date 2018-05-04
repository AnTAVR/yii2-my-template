<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require __DIR__ . '/common.php', require __DIR__ . '/common_web.php', [
    'id' => 'basic-tests',
//    'container' => [
//        'definitions' => [
//            'yii\bootstrap\ActiveForm' => [
//                'enableClientValidation' => false,
//            ],
//            'yii\widgets\ActiveForm' => [
//                'enableClientValidation' => false,
//            ],
//        ],
//    ],
    'components' => [
        'request' => [
            'scriptFile' => dirname(dirname(__DIR__)) . '/index-test.php',
            'cookieValidationKey' => 'test',
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
]);
