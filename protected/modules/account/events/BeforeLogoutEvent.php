<?php

namespace app\modules\account\events;

use app\modules\account\models\User;
use Yii;

class BeforeLogoutEvent
{
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        $username = '';
        $identity = Yii::$app->user->identity;
        /** @var $identity User */
        if ($identity->hasProperty('username')) {
            $username = $identity->username;
        }

        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye {username}!', ['username' => $username]));
    }
}
