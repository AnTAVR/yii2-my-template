<?php

namespace app\modules\account\acctions;

use Yii;
use yii\base\Action;

class LogoutAction extends Action
{
    /**
     * @return string
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;

        Yii::$app->user->logout();

        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye {username}', ['username' => $identity->username]));

        return $this->controller->goHome();
    }

}
