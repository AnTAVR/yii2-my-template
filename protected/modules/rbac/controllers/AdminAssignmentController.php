<?php

namespace app\modules\rbac\controllers;

use app\components\AdminController;
use app\modules\account\models\User;
use app\modules\rbac\models\forms\AssignmentForm;
use app\modules\rbac\models\searches\AssignmentSearch;
use Yii;
use yii\web\NotFoundHttpException;

class AdminAssignmentController extends AdminController
{
    public $layout = '@app/views/layouts/admin';

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
        ];
    }

    /**
     * Show list of user for assignment
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentSearch;
        $dataProvider = $searchModel->search();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Assignment roles to user
     * @param integer $id The user id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        $model = new AssignmentForm($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}
