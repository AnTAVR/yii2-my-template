<?php

namespace app\modules\account\events;

use app\modules\account\models\User;
use Yii;

class AfterLoginEvent
{

    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        /** @var $identity User */
        $identity = Yii::$app->user->identity;
        $username = $identity->username;
        Yii::$app->session->addFlash('success', Yii::t('app', 'Hello {username}!', ['username' => $username]));
    }
}
