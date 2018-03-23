<?php

namespace app\modules\backup\helpers;

use yii\helpers\StringHelper;

class PostgresDump extends BaseDump
{
    public static function makeDumpCommand($path, $dbInfo)
    {
        $arguments = [];
        if (static::isWindows()) {
            $arguments[] = "set PGPASSWORD='{$dbInfo['password']}'";
            $arguments[] = '&';
        } else {
            $arguments[] = "PGPASSWORD='{$dbInfo['password']}'";
        }
        $arguments[] = 'pg_dump';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--username=' . $dbInfo['username'];
        $arguments[] = '--no-password';
        $arguments[] = $dbInfo['dbName'];
        $arguments[] = '|';
        $arguments[] = 'gzip';
        $arguments[] = '>';
        $arguments[] = $path;
        return implode(' ', $arguments);
    }

    public static function makeRestoreCommand($path, $dbInfo)
    {
        $arguments = [];
        if (StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $path;
            $arguments[] = '|';
        }
        if (static::isWindows()) {
            $arguments[] = "set PGPASSWORD='{$dbInfo['password']}'";
            $arguments[] = '&';
        } else {
            $arguments[] = "PGPASSWORD='{$dbInfo['password']}'";
        }
        $arguments[] = 'psql';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--username=' . $dbInfo['username'];
        $arguments[] = '--no-password';
        $arguments[] = $dbInfo['dbName'];
        if (!StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $path;
        }
        return implode(' ', $arguments);
    }
}