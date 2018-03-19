<?php

use yii\helpers\ArrayHelper;

$config = [
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
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return ArrayHelper::merge(require __DIR__ . '/common.php', $config);
