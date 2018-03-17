<?php

namespace app\modules\account\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class LogoutController extends Controller
{
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
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
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;

        Yii::$app->user->logout();

        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye {username}', ['username' => $identity->username]));

        return $this->goHome();
    }
}
