<?php

namespace app\modules\account\events;

use Yii;

class AfterLoginEvent
{

    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;
        Yii::$app->session->addFlash('success', Yii::t('app', 'Hello {username}', ['username' => $identity->username]));
    }
}
