<?php

namespace app\modules\account\actions;

use app\modules\account\models\LoginForm;
use app\modules\account\models\User;
use Yii;
use yii\base\Action;
use yii\db\Expression;

class LoginAction extends Action
{
    /**
     * @return string
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne(['username' => $model->username]);
            if ($user->status == User::STATUS_ACTIVE) {
                $params = Yii::$app->getModule('account')->params;

                $login = Yii::$app->user->login($user, $model->rememberMe ? $params['duration'] : 0);
                if ($login) {
                    Yii::info("User [$model->username] is successfully logged in", __CLASS__);
                    $user->session = Yii::$app->session->id;
                    $user->last_login_at = new Expression('NOW()');
                    $user->save();

                    return $this->controller->goBack();
                }
            } else {
                $txt = Yii::t('app', 'User status: "{status}"', ['status' => $user->getStatusName()]);
                Yii::$app->session->addFlash('error', $txt);
                $model->addError('username', $txt);
            }
        }
        return $this->controller->render('@app/modules/account/views/login', [
            'model' => $model,
        ]);
    }

}
