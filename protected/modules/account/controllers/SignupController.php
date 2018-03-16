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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->signup()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Account successfully registered.'));

                if ($model->sendEmail()) {
                    Yii::$app->session->addFlash('success', Yii::t('app', 'A letter with instructions was sent to E-Mail.'));
                } else {
                    Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
                }
                return $this->goHome();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id integer
     * @param $token string
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionVerifyEmail($user_id, $token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = SignupForm::findOne($user_id);
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        if (!$model->validateEmailToken($token)) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }
        $model->verifyEmail();
        Yii::$app->session->addFlash('success', Yii::t('app', 'E-Mail is verified, now you can login.'));
        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
