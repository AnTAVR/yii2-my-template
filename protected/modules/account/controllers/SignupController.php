<?php

namespace app\modules\account\controllers;

use app\modules\account\models\SignupForm;
use app\modules\account\models\UserToken;
use Yii;
use yii\helpers\Url;
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
            $security = Yii::$app->security;

            $model->password_hash = $security->generatePasswordHash($model->password);
            $model->salt = $security->generateRandomString(64);
            $model->auth_key = $security->generateRandomString();
            $model->created_ip = Yii::$app->request->isConsoleRequest ? '(console)' : Yii::$app->request->userIP;
            $model->email_confirmed = (int)false;

            if ($model->save(false)) {
                //the following three lines were added:
//                $auth = Yii::$app->authManager;
//                $authorRole = $auth->getRole('author');
//                $auth->assign($authorRole, $model->getId());

                Yii::$app->session->addFlash('success', Yii::t('app', 'Account successfully registered.'));

                $tokenModel = new UserToken([
                    'user_id' => $model->id,
                    'code' => $model->token,
                    'type' => UserToken::TYPE_CONFIRM_EMAIL,
                    'expires_on' => time() + $this->module->params['expires_confirm_email'],
                ]);

                if ($tokenModel->save()) {
                    $url = Url::to(['verify-email', 'token' => $tokenModel->code], true);
                    $body = Yii::t('app', 'To confirm E-Mail, follow the link: {url}', ['url' => $url]);
                    $body .= "\n";
                    $body .= Yii::t('app', 'Is valid until: {expires}', ['expires' => $tokenModel->getExpiresTxt()]);
                    $body .= "\n";
                    $body .= "\n";
                    $body .= Yii::t('app', 'IP: {ip}', ['ip' => Yii::$app->request->userIP]);
                    $subject = Yii::t('app', 'Registration on the site {site}', ['site' => Yii::$app->name]);

                    $ret = Yii::$app->mailer->compose()
                        ->setTo($model->email)
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

        $tokenModel = UserToken::findByCode($token, UserToken::TYPE_CONFIRM_EMAIL);

        $model = SignupForm::findOne($tokenModel->user_id);
        $tokenModel->delete();

        if ($model) {
            if ($model->token !== $tokenModel->code) {
                throw new NotFoundHttpException(Yii::t('app', 'Token not found!'));
            }

            $model->email_confirmed = true;
            $model->save(false);
            Yii::$app->session->addFlash('success', Yii::t('app', 'E-Mail is verified, now you can login.'));
        }

        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
