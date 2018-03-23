<?php

namespace app\modules\backup\helpers;

use yii\helpers\StringHelper;

class PostgresDump extends BaseDump
{
    public static function makeDumpCommand($dumpFile, $dbInfo)
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
        $arguments[] = $dumpFile;
        return implode(' ', $arguments);
    }

    public static function makeRestoreCommand($dumpFile, $dbInfo)
    {
        $arguments = [];
        if (StringHelper::endsWith($dumpFile, '.gz', false)) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $dumpFile;
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
        if (!StringHelper::endsWith($dumpFile, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $dumpFile;
        }
        return implode(' ', $arguments);
    }
}