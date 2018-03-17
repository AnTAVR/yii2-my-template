<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordForm;
use app\modules\account\models\PasswordNewForm;
use app\modules\account\models\Token;
use app\modules\account\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PasswordController extends Controller
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

        $model = new PasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = User::findOne(['email' => $this->email]);

            $security = Yii::$app->security;
            $tokenModel = new Token([
                'user_id' => $user->id,
                'code' => $security->generateRandomString(),
                'type' => Token::TYPE_CONFIRM_EMAIL,
                'expires_on' => time() + 60 * 60 * 24,
            ]);
            $tokenModel->save();

            $url = Url::to(['new', 'token' => $tokenModel->code], true);
            $body = Yii::t('app', 'To password recovery, follow the link: {url}', ['url' => $url]);
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

        $tokenModel = Token::findByCode($token, Token::TYPE_CONFIRM_EMAIL);

        $model = PasswordNewForm::findOne($tokenModel->user_id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $security = Yii::$app->security;
            $model->password_hash = $security->generatePasswordHash($model->password);
            $model->save(false);

            $tokenModel->delete();

            Yii::$app->session->addFlash('success', Yii::t('app', 'New password was saved.'));
            return $this->redirect(Yii::$app->user->loginUrl);
        }
        return $this->render('new', [
            'model' => $model,
        ]);
    }
}
