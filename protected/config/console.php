<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require __DIR__ . '/common.php', [
    'id' => 'basic-console',
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => 'bariew\moduleMigration\ModuleMigrateController',
        ],
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
        ],
    ],
]);
