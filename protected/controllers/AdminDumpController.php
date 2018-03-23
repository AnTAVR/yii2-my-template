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
}
