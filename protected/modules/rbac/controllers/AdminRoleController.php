<?php

namespace app\modules\rbac\controllers;

use app\components\AdminController;
use app\modules\rbac\models\Role;
use app\modules\rbac\models\searches\RoleSearch;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AdminRoleController extends AdminController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['rbac.openAdminPanel'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $name
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionView($name)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => $name,
                'content' => $this->renderPartial('view', [
                    'model' => $this->findModel($name),
                ]),
                'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a(Yii::t('app', 'Edit'), ['update', 'name' => $name], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        }
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * @param string $name
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = Role::find($name)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Role model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return array|string|Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Role(null);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('app', 'Create new {0}', ['Role']),
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => Yii::t('app', "Create new {0}", ["Role"]),
                    'content' => '<span class="text-success">' . Yii::t('app', "Have been create new {0} success", ["Role"]) . '</span>',
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a(Yii::t('app', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('app', "Create new {0}", ["Role"]),
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'name' => $model->name]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Role model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @return array|string|Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionUpdate($name)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($name);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('app', 'Update {0}', ['"' . $name . '" Role']),
                    'content' => $this->renderPartial('update', [
                        'model' => $this->findModel($name),
                    ]),
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => $name,
                    'content' => $this->renderPartial('view', [
                        'model' => $this->findModel($name),
                    ]),
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a(Yii::t('app', 'Edit'), ['update', 'name' => $name], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('app', 'Update {0}', ['"' . $name . '" Role']),
                    'content' => $this->renderPartial('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'name' => $model->name]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Role model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionDelete($name)
    {
        $request = Yii::$app->request;
        $this->findModel($name)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

}
