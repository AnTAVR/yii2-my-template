<?php

namespace app\modules\account\events;

use Yii;

class BeforeLogoutEvent
{
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        $username = '';
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;
        if ($identity->hasProperty('username')) {
            $username = $identity->username;
        }

        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye {username}!', ['username' => $username]));
    }
}
