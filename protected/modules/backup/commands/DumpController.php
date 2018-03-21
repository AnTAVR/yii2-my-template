<?php

namespace app\modules\backup\commands;

use PDO;
use PDOException;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\Console;

class DumpController extends Controller
{
    public $defaultAction = 'create';

    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionRestore($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionTestConnection()
    {
        $dbInfo = static::getDbInfo();
        try {
            new PDO($dbInfo['dsn'], $dbInfo['username'], $dbInfo['password']);
            Console::output('Connection success.');
        } catch (PDOException $e) {
            Console::output('Connection failed: ' . $e->getMessage());
        }
    }

    protected static function getDbInfo($db = 'db')
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
