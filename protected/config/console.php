<?php
$params = require __DIR__ . '/common/params.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';
$modules = require __DIR__ . '/common/modules.php';
$container = require __DIR__ . '/container.php';
$aliases = require __DIR__ . '/common/aliases.php';

$config = [
    'id' => 'basic-console', //+
    'controllerNamespace' => 'app\commands',
    'components' => [
        'i18n' => $i18n,
        'db' => $db,
    ],
    'aliases' => $aliases,
    'container' => $container,
    'modules' => $modules,
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
