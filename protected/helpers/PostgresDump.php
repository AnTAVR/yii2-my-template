<?php

namespace app\helpers;

use yii\helpers\StringHelper;

class PostgresDump extends BaseDump
{
    public static function makeDumpCommand($path, $dbName, $host, $username, $password, $port = '5432')
    {
        $arguments = [];
        if (static::isWindows()) {
            $arguments[] = "set PGPASSWORD='{$password}'";
            $arguments[] = '&';
        } else {
            $arguments[] = "PGPASSWORD='{$password}'";
        }
        $arguments[] = 'pg_dump';
        $arguments[] = '--host=' . $host;
        $arguments[] = '--port=' . $port;
        $arguments[] = '--username=' . $username;
        $arguments[] = '--no-password';
        $arguments[] = $dbName;
        $arguments[] = '|';
        $arguments[] = 'gzip';
        $arguments[] = '>';
        $arguments[] = $path;
        return implode(' ', $arguments);
    }

    public static function makeRestoreCommand($path, $dbName, $host, $username, $password, $port = '5432')
    {
        $arguments = [];
        if (StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $path;
            $arguments[] = '|';
        }
        if (static::isWindows()) {
            $arguments[] = "set PGPASSWORD='{$password}'";
            $arguments[] = '&';
        } else {
            $arguments[] = "PGPASSWORD='{$password}'";
        }
        $arguments[] = 'psql';
        $arguments[] = '--host=' . $host;
        $arguments[] = '--port=' . $port;
        $arguments[] = '--username=' . $username;
        $arguments[] = '--no-password';
        $arguments[] = $dbName;
        if (!StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $path;
        }
        return implode(' ', $arguments);
    }
}