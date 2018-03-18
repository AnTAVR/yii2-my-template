<?php

namespace app\modules\account\events;

use Yii;

class BeforeLogoutEvent
{
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;
        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye {username}', ['username' => $identity->username]));
    }
}
