<?php

namespace app\modules\rbac\controllers;

use app\components\AdminController;
use app\modules\account\models\User;
use app\modules\rbac\models\forms\AssignmentForm;
use app\modules\rbac\models\searches\AssignmentSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AdminAssignmentController is controller for manager user assignment
 */
class AdminAssignmentController extends AdminController
{
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
    public function actionAssignment($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        $model = new AssignmentForm($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->refresh();
        }

        return $this->render('assignment', [
            'model' => $model,
        ]);
    }

}
