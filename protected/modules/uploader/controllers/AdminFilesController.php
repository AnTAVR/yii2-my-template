<?php

namespace app\modules\uploader\controllers;

use app\components\AdminController;
use app\modules\uploader\models\forms\UploaderFileForm;
use app\modules\uploader\models\UploaderFile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * AdminFilesController implements the CRUD actions for UploaderFile model.
 */
class AdminFilesController extends AdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                    'upload' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all UploaderFile models.
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UploaderFile::find(),
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC,],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UploaderFile model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the UploaderFile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UploaderFile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploaderFile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Updates an existing UploaderFile model.
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new UploaderFile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     */
    public function actionCreate()
    {
        $model = new UploaderFileForm();

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        $model = new UploaderFileForm();

        if (!$model->load(Yii::$app->request->post())) {
            return Json::encode($model->errors);
        }

        return $model->upload();
    }

    /** @noinspection PhpUndefinedClassInspection */
    /**
     * Deletes an existing UploaderFile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }
}
