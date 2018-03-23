<?php

namespace app\controllers;

use app\components\AdminController;
use app\helpers\BaseDump;
use Yii;
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
        return $this->render('index');
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
            foreach ($fileList as $fileName) {
                $dumpFile = BaseDump::getPath() . DIRECTORY_SEPARATOR . $fileName;
                if (!unlink($dumpFile)) {
                    $fail[] = $fileName;
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
}
