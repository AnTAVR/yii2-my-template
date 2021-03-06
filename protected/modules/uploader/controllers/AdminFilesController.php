<?php

namespace app\modules\uploader\controllers;

use app\modules\uploader\models\forms\UploaderFileForm;
use app\modules\uploader\models\UploaderFile;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AdminFilesController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['uploader.openAdminPanel'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                    'upload' => ['post'],
                ],
            ],
        ];
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
     * @param integer $id
     * @return UploaderFile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploaderFile::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Updates an existing UploaderFile model.
     * @param integer $id
     * @return string|Response
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

    /**
     * Deletes an existing UploaderFile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }
}
