<?php
return [
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
];
