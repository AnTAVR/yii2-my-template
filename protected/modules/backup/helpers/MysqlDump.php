<?php

namespace app\modules\backup\helpers;

use yii\helpers\StringHelper;

class MysqlDump extends BaseDump
{
    public static function makeDumpCommand($dumpFile, $dbInfo)
    {
        $arguments = [];
        $arguments[] = 'mysqldump';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--user=' . $dbInfo['username'];
        $arguments[] = "--password='{$dbInfo['password']}'";
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
        $arguments[] = 'mysql';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--user=' . $dbInfo['username'];
        $arguments[] = "--password='{$dbInfo['password']}'";
        $arguments[] = $dbInfo['dbName'];
        if (!StringHelper::endsWith($dumpFile, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $dumpFile;
        }

        return implode(' ', $arguments);
    }
}
