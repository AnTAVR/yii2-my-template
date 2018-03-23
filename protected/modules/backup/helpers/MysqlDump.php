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

        $endsWithGZ = StringHelper::endsWith($dumpFile, '.gz', false);

        if ($endsWithGZ) {
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

        if (!$endsWithGZ) {
            $arguments[] = '<';
            $arguments[] = $dumpFile;
        }

        return implode(' ', $arguments);
    }
}
