<?php

namespace app\modules\backup\helpers;

use yii\helpers\StringHelper;

class MysqlDump extends BaseDump
{
    public static function makeDumpCommand($path, $dbInfo)
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
        $arguments[] = 'mysql';
        $arguments[] = '--host=' . $dbInfo['host'];
        $arguments[] = '--port=' . $dbInfo['port'];
        $arguments[] = '--user=' . $dbInfo['username'];
        $arguments[] = "--password='{$dbInfo['password']}'";
        $arguments[] = $dbInfo['dbName'];
        if (!StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $path;
        }

        return implode(' ', $arguments);
    }
}
