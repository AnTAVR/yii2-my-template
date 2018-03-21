<?php

namespace app\modules\backup\helpers;

use Yii;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

abstract class BaseDump
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
        $params = Yii::$app->getModule('backup')->params;
        $path = Yii::getAlias($params['savePath']);
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
        return $fileList;
    }

    /**
     * @param string $path
     * @param string $dbName
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $port
     * @return string
     */
    abstract public static function makeDumpCommand($path, $dbName, $host, $username, $password, $port);

    /**
     * @param string $path
     * @param string $dbName
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $port
     * @return string
     */
    abstract public static function makeRestoreCommand($path, $dbName, $host, $username, $password, $port);

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    public static function getDbInfo($db = 'db')
    {
        $db = Instance::ensure($db, Connection::class);
        $dbInfo = [];
        $dbInfo['driverName'] = $db->driverName;
        $dbInfo['dsn'] = $db->dsn;
        $dbInfo['host'] = static::getDsnAttribute('host', $db->dsn);
        $dbInfo['port'] = static::getDsnAttribute('port', $db->dsn);
        $dbInfo['dbName'] = static::getDsnAttribute('dbname', $db->dsn);
        $dbInfo['username'] = $db->username;
        $dbInfo['password'] = $db->password;
        $dbInfo['prefix'] = $db->tablePrefix;

        if (!$dbInfo['port']) {
            if ($dbInfo['driverName'] === 'mysql') {
                $dbInfo['port'] = '3306';
            } elseif ($dbInfo['driverName'] === 'pgsql') {
                $dbInfo['port'] = '5432';
            }
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