<?php

use yii\helpers\ArrayHelper;

$_db_tmp = [
    'dsn' => 'mysql:host=localhost;dbname=tests_tests',
];

return ArrayHelper::merge(require __DIR__ . '/db.php', $_db_tmp);
