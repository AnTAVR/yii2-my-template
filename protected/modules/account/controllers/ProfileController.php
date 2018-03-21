<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordEditForm;
use app\modules\account\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionDelete()
    {
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;
        $identity->status = User::STATUS_DELETED;
        $identity->save();
        Yii::$app->user->logout(false);

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }

    /**
     * @return string
     */
    public function actionPasswordEdit()
    {
        $model = new PasswordEditForm();

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $model->edit();
        }
        return $this->render('password-edit', [
            'model' => $model,
        ]);
    }
}
