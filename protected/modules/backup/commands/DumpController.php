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

/**
 * Allows you to combine and compress your JavaScript and CSS files.
 **/
class DumpController extends Controller
{
    public $defaultAction = 'create';

    /**
     * @return int
     * @throws NotSupportedException
     */
    public function actionCreate()
    {
        if (!$this->confirm('Create dump?')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dbInfo = BaseDump::getDbInfo();
        $dumpFile = BaseDump::makePath($dbInfo['dbName']);

        if ($dbInfo['driverName'] === 'mysql') {
            $command = MysqlDump::makeDumpCommand($dumpFile, $dbInfo);
        } elseif ($dbInfo['driverName'] === 'pgsql') {
            $command = PostgresDump::makeDumpCommand($dumpFile, $dbInfo);
        }

        Yii::debug(compact('dumpFile', 'command'), get_called_class());

        $process = new Process($command);
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
        $fileList = BaseDump::getFilesList();
        $in_array = false;
        foreach ($fileList as $file) {
            if ($fileName === $file['basename']) {
                $in_array = true;
                break;
            }
        }

        if (!$in_array) {
            Console::output('File not found.');
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm("Restore dump '{$fileName}'?")) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dbInfo = BaseDump::getDbInfo();
        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        if ($dbInfo['driverName'] === 'mysql') {
            $command = MysqlDump::makeRestoreCommand($dumpFile, $dbInfo);
        } elseif ($dbInfo['driverName'] === 'pgsql') {
            $command = PostgresDump::makeRestoreCommand($dumpFile, $dbInfo);
        }

        Yii::debug(compact('dumpFile', 'command'), get_called_class());

        $process = new Process($command);
        $process->run();
        if ($process->isSuccessful()) {
            Console::output('Dump successfully restored.');
            return ExitCode::OK;
        }
        Console::output('Dump failed restored.');
        return ExitCode::UNSPECIFIED_ERROR;
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
