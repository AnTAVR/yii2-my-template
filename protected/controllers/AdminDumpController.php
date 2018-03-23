<?php

namespace app\controllers;

use app\components\AdminController;
use app\helpers\BaseDump;
use app\helpers\DumpInterface;
use Symfony\Component\Process\Process;
use Yii;
use yii\base\NotSupportedException;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * AdminDumpController.
 */
class AdminDumpController extends AdminController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => '\yii\filters\VerbFilter',
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                    'delete-all' => ['post'],
                    'download' => ['post'],
                    'restore' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $fileList = BaseDump::getFilesList();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $fileList,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionCreate()
    {
        try {
            $dbInfo = BaseDump::getDbInfo();
        } catch (NotSupportedException $e) {
            throw new HttpException($e->getMessage());
        }

        $dumpFile = BaseDump::makePath($dbInfo['dbName']);

        /** @var DumpInterface $manager */
        $manager = $dbInfo['manager'];
        $command = $manager::makeDumpCommand($dumpFile, $dbInfo);

        Yii::debug(compact('dumpFile', 'command'), get_called_class());

        $this->runProcess($command);

        return $this->redirect(['index']);
    }

    /**
     * @param string $fileName Name File Dump
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownload($fileName)
    {
        static::testFileName($fileName);

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        return Yii::$app->response->sendFile($dumpFile);
    }

    /**
     * @param string $fileName Name File Dump
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($fileName)
    {
        static::testFileName($fileName);

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        if (unlink($dumpFile)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Dump deleted successfully.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Error deleting dump.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteAll()
    {
        $fileList = BaseDump::getFilesList();

        if ($fileList) {
            $fail = [];
            $path = BaseDump::getPath() . DIRECTORY_SEPARATOR;
            foreach ($fileList as $file) {
                $fileName = $path . $file['file'];
                if (!unlink($fileName)) {
                    $fail[] = $file;
                }
            }

            if (empty($fail)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'All dumps successfully removed.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error deleting dumps.'));
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * @param string $fileName Name File Dump
     * @throws NotFoundHttpException
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
     * @param string $command
     * @param bool $isRestore
     */
    protected static function runProcess($command, $isRestore = false)
    {
        $process = new Process($command);
        $process->run();
        if ($process->isSuccessful()) {
            $msg = !$isRestore ? Yii::t('app', 'Dump successfully created.') : Yii::t('app', 'Dump successfully restored.');
            Yii::$app->session->addFlash('success', $msg);
        } else {
            $msg = !$isRestore ? Yii::t('app', 'Dump failed.') : Yii::t('app', 'Restore failed.');
            Yii::$app->session->addFlash('error', $msg . '<br>' . 'Command - ' . $command . '<br>' . $process->getOutput() . $process->getErrorOutput());
            Yii::error($msg . PHP_EOL . 'Command - ' . $command . PHP_EOL . $process->getOutput() . PHP_EOL . $process->getErrorOutput());
        }
    }
}
