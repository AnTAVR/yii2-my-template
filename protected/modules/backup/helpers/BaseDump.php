<?php

namespace app\modules\backup\helpers;

use Yii;
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
            FileHelper::createDirectory($path);
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

}