<?php

use yii\helpers\ArrayHelper;

$__config = [
    'id' => 'basic-console',
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => 'bariew\moduleMigration\ModuleMigrateController',
        /*
            'fixture' => [ // Fixture generation command line.
                'class' => 'yii\faker\FixtureController',
            ],
        */
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $__config['bootstrap'][] = 'gii';
    $__config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return ArrayHelper::merge(require __DIR__ . '/common.php', $__config);
