<?php
return [
    'components' => [
        'request' => [
            'csrfParam' => 'ckCsrfToken',
            'enableCsrfValidation' => !YII_ENV_TEST,
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
//        'session' => [
//            'class' => 'app\components\Session',
//                 @todo: Из за установки не работают тесты!!!
//                'savePath' => '@runtime/session',
//        ],
    ],
    'container' => [
        'definitions' => [
        ],
        'singletons' => [
            'yii\widgets\LinkPager' => [
                'class' => 'app\widgets\LinkPager\LinkPager',
                'lastPageLabel' => true,
                'firstPageLabel' => true,
                'jumpPageLabel' => true,
            ],
            'yii\grid\GridView' => [
                'layout' => "{pager}\n{summary}\n{items}\n{pager}",
            ],
        ],

    ],
];
