<?php

namespace app\modules\account\actions;

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

        Yii::$app->user->logout(false);

        return $this->controller->goHome();
    }

}
