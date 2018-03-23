<?php

namespace app\commands;

use app\helpers\BaseDump;
use app\helpers\MysqlDump;
use app\helpers\PostgresDump;
use PDO;
use PDOException;
use Symfony\Component\Process\Process;
use Yii;
use yii\base\NotSupportedException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Backup Dump DB.
 */
class DumpController extends Controller
{
    public $defaultAction = 'create';

    /**
     * Create Dump DB
     *
     * @return int
     */
    public function actionCreate()
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (NotSupportedException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm('Create dump?')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dumpFile = BaseDump::makePath($dbInfo['dbName']);

        if ($dbInfo['driverName'] === 'mysql') {
            $command = MysqlDump::makeDumpCommand($dumpFile, $dbInfo);
        } else {
            $command = PostgresDump::makeDumpCommand($dumpFile, $dbInfo);
        }

        Yii::debug(compact('dumpFile', 'command'), get_called_class());

        $process = new Process($command);
        $process->run();
        if ($process->isSuccessful()) {
            Console::output('Dump successfully created.');
            return ExitCode::OK;
        }

        Console::output('Dump failed create.');
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Restore Dump DB
     *
     * @param string $fileName Name File Dump
     * @return int
     */
    public function actionRestore($fileName)
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (NotSupportedException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

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

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        if ($dbInfo['driverName'] === 'mysql') {
            $command = MysqlDump::makeRestoreCommand($dumpFile, $dbInfo);
        } else {
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

    /**
     * Test DB Connection
     *
     * @return int
     */
    public function actionTest()
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (NotSupportedException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        try {
            new PDO($dbInfo['dsn'], $dbInfo['username'], $dbInfo['password']);
            Console::output('Connection success.');
            return ExitCode::OK;
        } catch (PDOException $e) {
            Console::output('Connection failed: ' . $e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    /**
     * List Dumps DB
     *
     * @return int
     */
    public function actionList()
    {
        $fileList = BaseDump::getFilesList();
        foreach ($fileList as $file) {
            Console::output($file['basename']);
        }
        return ExitCode::OK;
    }
}
