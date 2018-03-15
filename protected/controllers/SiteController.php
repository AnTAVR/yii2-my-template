<?php

namespace app\controllers;

use app\models\CallbackForm;
use app\models\ContactForm;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => (YII_ENV_TEST or YII_ENV_DEV) ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays a single StaticPage model.
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        /** @noinspection RequireParameterInspection */
        return $this->render('@app/views/static/index', [
            'model' => StaticController::findModel('index'),
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us.') . ' ' . Yii::t('app', 'We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionCallback()
    {
        $model = new CallbackForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us.') . ' ' . Yii::t('app', 'We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        return $this->render('callback', [
            'model' => $model,
        ]);
    }
}
