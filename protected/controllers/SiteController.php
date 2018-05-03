<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => (YII_ENV_TEST || YII_ENV_DEV) ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays a single StaticPage model.
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        /** @noinspection RequireParameterInspection */
        return $this->render('../static/index', [
            'model' => StaticController::findModel('index'),
        ]);
    }
}
