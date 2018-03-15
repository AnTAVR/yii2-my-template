<?php

namespace app\modules\account\controllers;

use app\modules\account\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class LoginController extends Controller
{
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var $identity \app\modules\account\models\User */
            $identity = Yii::$app->user->identity;
            Yii::$app->session->setFlash('success', Yii::t('app', 'Hello {username}', ['username' => $identity->username]));

            return $this->goBack();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
