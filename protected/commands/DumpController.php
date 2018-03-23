<?php

namespace app\commands;

use app\helpers\BaseDump;
use app\helpers\DumpInterface;
use PDO;
use PDOException;
use Symfony\Component\Process\Process;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

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
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (HttpException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm('Create dump?')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dumpFile = BaseDump::makePath($dbInfo['dbName']);

        /** @var DumpInterface $manager */
        $manager = $dbInfo['manager'];
        $command = $manager::makeDumpCommand($dumpFile, $dbInfo);

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
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRestore($fileName)
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (HttpException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        try {
            static::testFileName($fileName);
        } catch (NotFoundHttpException $e) {
            Console::output($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm("Restore dump '{$fileName}'?")) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        /** @var DumpInterface $manager */
        $manager = $dbInfo['manager'];
        $command = $manager::makeRestoreCommand($dumpFile, $dbInfo);

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
     * @param string $fileName Name File Dump
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public static function testFileName($fileName)
    {
        $fileList = BaseDump::getFilesList();
        $in_array = false;
        foreach ($fileList as $file) {
            if ($fileName === $file['file']) {
                $in_array = true;
                break;
            }
        }

        if (!$in_array) {
            throw new NotFoundHttpException('File not found.');
        }
    }

    /**
     * Test DB Connection
     *
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTest()
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (HttpException $e) {
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
     * @throws \yii\base\Exception
     */
    public function actionList()
    {
        $fileList = BaseDump::getFilesList();
        foreach ($fileList as $file) {
            Console::output($file['file']);
        }
        return ExitCode::OK;
    }
}
