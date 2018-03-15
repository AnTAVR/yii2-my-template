<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordResetForm;
use app\modules\account\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class SignupController extends Controller
{
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'password-reset'],
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
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        $model = new SignupForm(['scenario' => 'signup']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->signup();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionPasswordReset()
    {
        $model = new PasswordResetForm(['scenario' => 'password-reset']);

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $model->reset();
        }
        return $this->render('password-reset', [
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id integer
     * @param $crc string
     * @return string
     */
    public function actionVerifyEmail(/** @noinspection PhpUnusedParameterInspection */
        $user_id, $crc)
    {
        return (string)$user_id . ' ' . (string)$crc;
    }
}
