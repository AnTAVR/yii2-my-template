<?php

namespace app\modules\rbac\controllers;

use app\components\AdminController;
use app\modules\rbac\models\Permission;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AdminPermissionController extends AdminController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ]);
    }

    /**
     * Lists all Permission models.
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => Permission::findAll(),
            'pagination' => [
                'defaultPageSize' => $this->module->params['adminPageSize'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permission model.
     * @param string $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => $id,
                'content' => $this->renderPartial('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a(Yii::t('app', 'Edit'), ['update', 'name' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param string $id
     * @return Permission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Permission::find($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Permission model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return array|string|Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Permission(null);
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Permission model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return array|string|Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Delete an existing Permission model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}
