<?php

namespace app\modules\account\controllers;

use app\modules\account\models\forms\SignupForm;
use app\modules\account\models\User;
use app\modules\account\models\UserToken;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VerifyMailController extends Controller
{
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @param $token string
     * @return string
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws \Throwable
     * @throws yii\db\StaleObjectException
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function actionIndex($token)
    {
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

        return $this->redirect(['/site/login']);
    }
}
