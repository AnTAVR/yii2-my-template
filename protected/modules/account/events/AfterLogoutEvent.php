<?php

namespace app\modules\account\events;

use Yii;

class AfterLogoutEvent
{
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        Yii::$app->session->addFlash('success', Yii::t('app', 'Goodbye!!!'));
    }
}
