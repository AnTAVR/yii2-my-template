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
                    $user->session = Yii::$app->session->id;
                    $user->session_at = new Expression('NOW()');
                    $user->save();

                    return $this->controller->goBack();
                }
            } else {
                $model->addError('username', Yii::t('app', 'User "{username}" status: "{status}"', ['username' => $user->username, 'status' => $user->getStatusName()]));
            }
        }
        return $this->controller->render('@app/modules/account/views/login', [
            'model' => $model,
        ]);
    }

}
