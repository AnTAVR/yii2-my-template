<?php

namespace app\modules\account\controllers;

use app\modules\account\models\SignupForm;
use app\modules\account\models\User;
use app\modules\account\models\UserToken;
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
            return $this->goHome();
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

        $tokenModel = UserToken::findByCode($token, UserToken::TYPE_CONFIRM_EMAIL);

        $model = SignupForm::findOne($tokenModel->user_id);
        $tokenModel->delete();

        if ($model->status == User::STATUS_ACTIVE) {
            if ($model->tokenEmail !== $tokenModel->code) {
                throw new NotFoundHttpException(Yii::t('app', 'Token not found!'));
            }

            $model->email_confirmed = true;
            $model->save(false);
            Yii::$app->session->addFlash('success', Yii::t('app', 'E-Mail is verified, now you can login.'));
        } else {
            $txt = Yii::t('app', 'User status: "{status}"', ['status' => $model->getStatusName()]);
            Yii::$app->session->addFlash('error', $txt);
            $model->addError('user', $txt);
        }

        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
