<?php

namespace app\modules\account\controllers;

use app\modules\account\models\SignupForm;
use app\modules\account\models\Token;
use app\modules\account\models\User;
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

    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @param $token string
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionVerifyEmail($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $tokenModel = Token::findByCode($token, Token::TYPE_CONFIRM_EMAIL);

        $model = User::findOne($tokenModel->user_id);

        $model->email_confirmed = true;
        $model->save(false);

        Yii::$app->session->addFlash('success', Yii::t('app', 'E-Mail is verified, now you can login.'));
        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
