<?php

namespace app\helpers\dump;

use yii\helpers\StringHelper;

class PostgresDump extends DumpInterface
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

        $endsWithGZ = StringHelper::endsWith($dumpFile, '.gz', false);
        $isWindows = static::isWindows();

        if ($isWindows) {
            $arguments[] = "set PGPASSWORD='{$dbInfo['password']}'";
            $arguments[] = '&';
        }

        if ($endsWithGZ) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $dumpFile;
            $arguments[] = '|';
        }

        if (!$isWindows) {
            $arguments[] = "PGPASSWORD='{$dbInfo['password']}'";
        }

        $arguments[] = 'psql';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--username=' . $dbInfo['username'];
        $arguments[] = '--no-password';
        $arguments[] = $dbInfo['dbName'];

        if (!$endsWithGZ) {
            $arguments[] = '<';
            $arguments[] = $dumpFile;
        }

        return implode(' ', $arguments);
    }
}