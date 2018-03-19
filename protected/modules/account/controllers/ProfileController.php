<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordEditForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
        $identity = Yii::$app->user->identity;

        return $this->render('index', [
            'identity' => $identity,
        ]);
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
