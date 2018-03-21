<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=tests' . (YII_ENV_TEST ? '_tests' : ''),
    'username' => 'tests',
    'password' => 'teststests',
    'charset' => 'utf8',
    'enableSchemaCache' => !YII_ENV_DEV,
];
