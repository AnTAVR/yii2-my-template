<?php

namespace app\helpers;

use Yii;
use yii\base\NotSupportedException;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

class BaseDump
{
    /**
     * @param string $dbName
     * @return string
     */
    public static function makePath($dbName)
    {
        return static::getPath() . DIRECTORY_SEPARATOR . sprintf('%s_%s.%s',
                $dbName,
                date('Y-m-d_H-i-s'),
                'sql.gz'
            );
    }

    public static function getPath()
    {
        $params = Yii::$app->params;
        $path = Yii::getAlias($params['backups_path']) . DIRECTORY_SEPARATOR . 'db';
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0775, true);
        }
        return $path;
    }

    public static function getFilesList()
    {
        $files = FileHelper::findFiles(static::getPath(), ['only' => ['*.sql', '*.gz']]);
        $fileList = [];
        foreach ($files as $file) {
            $fileList[] = [
                'basename' => StringHelper::basename($file),
                'timestamp' => filectime($file),
            ];
        }
        ArrayHelper::multisort($fileList, ['timestamp'], [SORT_DESC]);
        return $fileList;
    }

    public static function getDbInfo($db = 'db')
    {
        $dbInfo = [];

        $db = Instance::ensure($db, Connection::class);

        $dbInfo['driverName'] = $db->driverName;
        $dbInfo['dsn'] = $db->dsn;
        $dbInfo['host'] = static::getDsnAttribute('host', $db->dsn);
        $dbInfo['port'] = static::getDsnAttribute('port', $db->dsn);
        $dbInfo['dbName'] = static::getDsnAttribute('dbname', $db->dsn);
        $dbInfo['username'] = $db->username;
        $dbInfo['password'] = $db->password;
        $dbInfo['prefix'] = $db->tablePrefix;

        if ($dbInfo['driverName'] === 'mysql') {
            $port = '3306';
            $dbInfo['manager'] = new MysqlDump();
        } elseif ($dbInfo['driverName'] === 'pgsql') {
            $port = '5432';
            $dbInfo['manager'] = new PostgresDump();
        } else {
            throw new NotSupportedException($dbInfo['driverName'] . ' driver unsupported!');
        }
        if (!$dbInfo['port']) {
            $dbInfo['port'] = $port;
        }

        return $dbInfo;
    }

    protected static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

}