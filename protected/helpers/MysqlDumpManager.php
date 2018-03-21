<?php

namespace app\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class MysqlDumpManager
{
    public static function makeDumpCommand($path, $dbName, $host, $username, $password, $port = '3306')
    {
        $arguments = [
            'mysqldump',
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            "--password='{$password}'",
        ];
        $arguments[] = $dbName;
        $arguments[] = '|';
        $arguments[] = 'gzip';
        $arguments[] = '>';
        $arguments[] = $path;

        return implode(' ', $arguments);
    }

    public static function makeRestoreCommand($path, $dbName, $host, $username, $password, $port = '3306')
    {
        $arguments = [];
        if (StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $path;
            $arguments[] = '|';
        }
        $arguments = ArrayHelper::merge($arguments, [
            'mysql',
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            "--password='{$password}'",
        ]);
        $arguments[] = $dbName;
        if (!StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $path;
        }

        return implode(' ', $arguments);
    }
}
