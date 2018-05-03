<?php

namespace app\controllers;

use app\models\forms\CallbackForm;
use Yii;
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

    public function actionCallback()
    {
        $model = new CallbackForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Thank you for contacting us.') . ' ' . Yii::t('app', 'We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        return $this->render('callback', [
            'model' => $model,
        ]);
    }
}
