<?php

namespace app\modules\account\events;

use Yii;
use yii\db\ActiveRecord;

class BeforeRequestEvent
{
    /**
     * @param $event
     */
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        /** @var $user \app\modules\account\models\User */
        $user = Yii::$app->user->identity;
        if ($user instanceof ActiveRecord) {
            /** @noinspection PhpUndefinedMethodInspection */
            $user->touch('last_request_at');
            $user->save(false);
        }
    }
}
