<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require __DIR__ . '/db.php', [
    'dsn' => 'mysql:host=localhost;dbname=tests_tests',
]);
