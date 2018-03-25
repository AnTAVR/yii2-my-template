<?php

namespace app\modules\account\controllers;

use app\modules\account\models\forms\RecoveryPasswordForm;
use app\modules\account\models\RecoveryPasswordNewForm;
use app\modules\account\models\User;
use app\modules\account\models\UserToken;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RecoveryController extends Controller
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

        $model = new RecoveryPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = RecoveryPasswordForm::findOne(['email' => $model->email]);
            if ($user->status == User::STATUS_ACTIVE) {
                $tokenModel = new UserToken([
                    'user_id' => $user->id,
                    'code' => $user->tokenPassword,
                    'type' => UserToken::TYPE_RECOVERY_PASSWORD,
                    'expires_on' => time() + $this->module->params['expires_recovery_password'],
                ]);

                if ($tokenModel->save()) {
                    $url = Url::to(['new', 'token' => $tokenModel->code], true);
                    $body = Yii::t('app', 'To password recovery, follow the link: {url}', ['url' => $url]);
                    $body .= "\n";
                    $body .= Yii::t('app', 'Is valid until: {expires}', ['expires' => $tokenModel->getExpiresTxt()]);
                    $body .= "\n";
                    $body .= "\n";
                    $body .= Yii::t('app', 'IP: {ip}', ['ip' => Yii::$app->request->userIP]);
                    $subject = Yii::t('app', 'Password recovery from {site}', ['site' => Yii::$app->name]);

                    $ret = Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{appname} robot', ['appname' => Yii::$app->name])])
                        ->setSubject($subject)
                        ->setTextBody($body)
                        ->send();
                    if ($ret) {
                        Yii::$app->session->addFlash('success', Yii::t('app', 'A letter with instructions was sent to E-Mail.'));
                    } else {
                        Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
                    }
                    return $this->goHome();
                } else {
                    $txt = Yii::t('app', 'A letter with instructions has already been sent to E-Mail.');
                    Yii::$app->session->addFlash('error', $txt);
                    $model->addError('email', $txt);
                }
            } else {
                $txt = Yii::t('app', 'User status: "{status}"', ['status' => $user->getStatusName()]);
                Yii::$app->session->addFlash('error', $txt);
                $model->addError('email', $txt);
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
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     * @throws \Throwable
     */
    public function actionNew($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $tokenModel = UserToken::findByCode($token, UserToken::TYPE_RECOVERY_PASSWORD);

        $model = RecoveryPasswordNewForm::findOne($tokenModel->user_id);
        if ($model->status == User::STATUS_ACTIVE) {
            if ($model->tokenPassword !== $tokenModel->code) {
                $tokenModel->delete();
                throw new NotFoundHttpException(Yii::t('app', 'Token not found!'));
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $security = Yii::$app->security;
                $model->password_hash = $security->generatePasswordHash($model->password);
                $model->save(false);

                Yii::$app->session->addFlash('success', Yii::t('app', 'New password was saved.'));

                $tokenModel->delete();
                return $this->redirect(Yii::$app->user->loginUrl);
            }
        } else {
            $tokenModel->delete();
            $txt = Yii::t('app', 'User status: "{status}"', ['status' => $model->getStatusName()]);
            Yii::$app->session->addFlash('error', $txt);
            $model->addError('password', $txt);
        }
        return $this->render('new', [
            'model' => $model,
        ]);
    }
}
