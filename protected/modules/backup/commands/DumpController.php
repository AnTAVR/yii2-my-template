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
use yii\console\ExitCode;
use yii\helpers\Console;

class DumpController extends Controller
{
    public $defaultAction = 'create';

    public function actionCreate()
    {
        $dbInfo = BaseDump::getDbInfo();
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
            return ExitCode::OK;
        } else {
            Console::output('Dump failed create.');
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    public function actionRestore(string $fileName)
    {
        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($dumpFile)) {
            throw new NotSupportedException('File not found.');
        }

        $dbInfo = BaseDump::getDbInfo();
        if ($dbInfo['driverName'] === 'mysql') {
            $manager = new MysqlDump();
        } elseif ($dbInfo['driverName'] === 'pgsql') {
            $manager = new PostgresDump();
        } else {
            throw new NotSupportedException($dbInfo['driverName'] . ' driver unsupported!');
        }

        $restoreCommand = $manager::makeRestoreCommand($dumpFile, $dbInfo['dbName'], $dbInfo['host'], $dbInfo['username'], $dbInfo['password'], $dbInfo['port']);

        Yii::debug(compact('restoreCommand', 'dumpFile'), get_called_class());

        $process = new Process($restoreCommand);
        $process->run();
        if ($process->isSuccessful()) {
            Console::output('Dump successfully restored.');
            return ExitCode::OK;
        } else {
            Console::output('Dump failed restored.');
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    public function actionTest()
    {
        $dbInfo = BaseDump::getDbInfo();
        try {
            new PDO($dbInfo['dsn'], $dbInfo['username'], $dbInfo['password']);
            Console::output('Connection success.');
            return ExitCode::OK;
        } catch (PDOException $e) {
            Console::output('Connection failed: ' . $e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    public function actionList()
    {
        $fileList = BaseDump::getFilesList();
        foreach ($fileList as $file) {
            Console::output($file['basename']);
        }
        return ExitCode::OK;
    }
}
