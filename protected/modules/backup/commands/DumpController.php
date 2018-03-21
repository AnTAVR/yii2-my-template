<?php

namespace app\modules\backup\commands;

use app\modules\backup\helpers\BaseDump;
use app\modules\backup\helpers\MysqlDump;
use app\modules\backup\helpers\PostgresDump;
use PDO;
use PDOException;
use Symfony\Component\Process\Process;
use Yii;
use yii\base\NotSupportedException;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

class DumpController extends Controller
{
    public $defaultAction = 'create';

    public function actionCreate()
    {
        $dbInfo = static::getDbInfo();
        if ($dbInfo['driverName'] === 'mysql') {
            $manager = new MysqlDump();
        } elseif ($dbInfo['driverName'] === 'pgsql') {
            $manager = new PostgresDump();
        } else {
            throw new NotSupportedException($dbInfo['driverName'] . ' driver unsupported!');
        }

        $dumpPath = BaseDump::makePath($dbInfo['dbName']);
        $dumpCommand = $manager::makeDumpCommand($dumpPath, $dbInfo['dbName'], $dbInfo['host'], $dbInfo['username'], $dbInfo['password'], $dbInfo['port']);

        Yii::debug(compact('dumpPath', 'dumpCommand'), get_called_class());

        $process = new Process($dumpCommand);
        $process->run();
        if ($process->isSuccessful()) {
            Console::output('Dump successfully created.');
        } else {
            Console::output('Dump failed create.');
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

    public function actionRestore(string $fileName)
    {
        $model = new Restore($this->getModule()->dbList);
        if (is_null($this->file)) {
            if ($this->storage) {
                if (Yii::$app->has('backupStorage')) {
                    foreach (Yii::$app->backupStorage->listContents() as $file) {
                        $fileList[] = [
                            'basename' => $file['basename'],
                            'timestamp' => $file['timestamp'],
                        ];
                    }
                } else {
                    Console::output('Storage component is not configured.');
                }
            } else {
                foreach ($this->getModule()->getFileList() as $file) {
                    $fileList[] = [
                        'basename' => StringHelper::basename($file),
                        'timestamp' => filectime($file),
                    ];
                }
            }
            ArrayHelper::multisort($fileList, ['timestamp'], [SORT_DESC]);
            $this->file = ArrayHelper::getValue(array_shift($fileList), 'basename');
        }

        $runtime = null;
        $dumpFile = null;
        if ($this->storage) {
            if (Yii::$app->has('backupStorage')) {
                if (Yii::$app->backupStorage->has($this->file)) {
                    $runtime = Yii::getAlias('@runtime/backups');
                    if (!is_dir($runtime)) {
                        FileHelper::createDirectory($runtime);
                    }
                    $dumpFile = $runtime . '/' . $this->file;
                    file_put_contents($dumpFile, Yii::$app->backupStorage->read($this->file));
                } else {
                    Console::output('File not found.');
                }
            } else {
                Console::output('Storage component is not configured.');
            }
        } else {
            $fileExists = $this->getModule()->path . $this->file;
            if (file_exists($fileExists)) {
                $dumpFile = $fileExists;
            } else {
                Console::output('File not found.');
            }
        }


        if (ArrayHelper::isIn($this->db, $this->getModule()->dbList)) {
            $dbInfo = $this->getModule()->getDbInfo($this->db);
            $restoreOptions = $model->makeRestoreOptions();
            $manager = $this->getModule()->createManager($dbInfo);
            $restoreCommand = $manager->makeRestoreCommand($dumpFile, $dbInfo, $restoreOptions);
            Yii::trace(compact('restoreCommand', 'dumpFile', 'restoreOptions'), get_called_class());
            $process = new Process($restoreCommand);
            $process->run();
            if (!is_null($runtime)) {
                FileHelper::removeDirectory($runtime);
            }
            if ($process->isSuccessful()) {
                Console::output('Dump successfully restored.');
            } else {
                Console::output('Dump failed restored.');
            }
        } else {
            Console::output('Database configuration not found.');
        }
    }

    public function actionTest()
    {
        $dbInfo = static::getDbInfo();
        try {
            new PDO($dbInfo['dsn'], $dbInfo['username'], $dbInfo['password']);
            Console::output('Connection success.');
        } catch (PDOException $e) {
            Console::output('Connection failed: ' . $e->getMessage());
        }
    }

    public function actionList()
    {
        $fileList = BaseDump::getFilesList();
        foreach ($fileList as $file) {
            Console::output($file['basename']);
        }
    }
}
