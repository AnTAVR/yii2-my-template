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
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        return $this->controller->goHome();
    }

}
