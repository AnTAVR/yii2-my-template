<?php

namespace app\modules\account\controllers;

use app\modules\account\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SignupController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var \app\modules\account\Module $module */
        $module = $this->module;

        if (!$module->params['signup']) {
            throw new NotFoundHttpException();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Account successfully registered.'));

            $ret = $model->sendVerifyEmailToken();
            if ($ret == null) {
                Yii::$app->session->addFlash('error', $model->getFirstError('email'));
            } elseif ($ret) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'A letter with instructions was sent to E-Mail.'));
                return $this->goHome();
            } else {
                Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
                return $this->goHome();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
