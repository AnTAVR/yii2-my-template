<?php

namespace app\helpers;

abstract class BaseDump
{
    /**
     * @param string $path
     * @param string $dbName
     * @return string
     */
    public static function makePath($path, $dbName)
    {
        return sprintf('%s%s_%s.%s',
            $path,
            $dbName,
            date('Y-m-d_H-i-s'),
            'sql.gz'
        );
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