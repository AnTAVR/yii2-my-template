<?php

namespace app\controllers;

use app\components\AdminController;
use app\helpers\BaseDump;
use Symfony\Component\Process\Process;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
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
                    'restore' => ['get', 'post'],
                    '*' => ['get'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $fileList = BaseDump::getFilesList();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $fileList,
        ]);

        $activePids = $this->checkActivePids();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'activePids' => $activePids,
        ]);
    }

    /**
     * @param string $fileName Name File Dump
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownload($fileName)
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
            throw new NotFoundHttpException('File not found.');
        }

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        return Yii::$app->response->sendFile($dumpFile);
    }

    public function actionDelete($fileName)
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
            throw new NotFoundHttpException('File not found.');
        }

        $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;

        if (unlink($dumpFile)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Dump deleted successfully.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Error deleting dump.'));
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        $fileList = BaseDump::getFilesList();

        if ($fileList) {
            $fail = [];
            $path = BaseDump::getPath() . DIRECTORY_SEPARATOR;
            foreach ($fileList as $file) {
                $fileName = $path . $file['basename'];
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
     * @param $command
     * @param bool $isRestore
     */
    protected function runProcess($command, $isRestore = false)
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

    /**
     * @param $command
     * @param bool $isRestore
     */
    protected function runProcessAsync($command, $isRestore = false)
    {
        $process = new Process($command);
        $process->start();
        $pid = $process->getPid();
        $activePids = Yii::$app->session->get('backupPids', []);
        if (!$process->isRunning()) {
            if ($process->isSuccessful()) {
                $msg = !$isRestore ? Yii::t('app', 'Dump successfully created.') : Yii::t('app', 'Dump successfully restored.');
                Yii::$app->session->addFlash('success', $msg);
            } else {
                $msg = !$isRestore ? Yii::t('app', 'Dump failed.') : Yii::t('app', 'Restore failed.');
                Yii::$app->session->addFlash('error', $msg . '<br>' . 'Command - ' . $command . '<br>' . $process->getOutput() . $process->getErrorOutput());
                Yii::error($msg . PHP_EOL . 'Command - ' . $command . PHP_EOL . $process->getOutput() . PHP_EOL . $process->getErrorOutput());
            }
        } else {
            $activePids[$pid] = $command;
            Yii::$app->session->set('backupPids', $activePids);
            Yii::$app->session->addFlash('info', Yii::t('app', 'Process running with pid={pid}', ['pid' => $pid]) . '<br>' . $command);
        }
    }

    /**
     * @return array
     */
    protected function checkActivePids()
    {
        $activePids = Yii::$app->session->get('backupPids', []);
        $newActivePids = [];
        if (!empty($activePids)) {
            foreach ($activePids as $pid => $cmd) {
                $process = new Process('ps -p ' . $pid);
                $process->run();
                if (!$process->isSuccessful()) {
                    Yii::$app->session->addFlash('success',
                        Yii::t('app', 'Process complete!') . '<br> PID=' . $pid . ' ' . $cmd);
                } else {
                    $newActivePids[$pid] = $cmd;
                }
            }
        }
        Yii::$app->session->set('backupPids', $newActivePids);
        return $newActivePids;
    }
}
