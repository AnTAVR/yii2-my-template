<?php
$params = require __DIR__ . '/common/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console', //+
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => $db,
    ],
    'params' => $params,
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

return $config;
