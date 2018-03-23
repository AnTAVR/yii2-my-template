<?php

namespace app\helpers;

use Yii;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\web\HttpException;

class BaseDump
{
    const PATH_DB = 'db';

    /**
     * @param string $dbName
     * @return string
     * @throws \yii\base\Exception
     */
    public static function makePath($dbName)
    {
        return static::getPath() . DIRECTORY_SEPARATOR . sprintf('%s_%s.%s',
                $dbName,
                date('Y-m-d_H-i-s'),
                'sql.gz'
            );
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public static function getPath()
    {
        $path = Yii::getAlias('@backups') . DIRECTORY_SEPARATOR . static::PATH_DB;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0775, true);
        }
        return $path;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public static function getFilesList()
    {
        $files = FileHelper::findFiles(static::getPath(), ['only' => ['*.sql', '*.gz']]);
        $fileList = [];
        foreach ($files as $file) {
            $fileList[] = [
                'file' => StringHelper::basename($file),
                'created_at' => filectime($file),
            ];
        }
        ArrayHelper::multisort($fileList, ['created_at'], [SORT_DESC]);
        return $fileList;
    }

    /**
     * @param string $db
     * @return array
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
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
            throw new HttpException($dbInfo['driverName'] . ' driver unsupported!');
        }
        if (!$dbInfo['port']) {
            $dbInfo['port'] = $port;
        }

        return $dbInfo;
    }

    /**
     * @param string $name
     * @param string $dsn
     * @return string | null
     */
    protected static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

}