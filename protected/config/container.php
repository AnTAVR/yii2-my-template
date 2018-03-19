<?php
return [
    'definitions' => [
        'yii\i18n\Formatter' => 'app\components\Formatter',
        'yii\web\View' => 'app\components\View',
        'yii\web\Session' => [
            'class' => 'app\components\Session',
            'savePath' => '@runtime/session',
        ],
    ],
    'singletons' => [
    ],
];
