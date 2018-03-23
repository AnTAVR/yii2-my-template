<?php

namespace app\modules\account\events;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

class BeforeRequestEvent
{
    public static function run(/** @noinspection PhpUnusedParameterInspection */
        $event)
    {
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;
        if ($identity instanceof ActiveRecord) {
            $identity->last_request_at = new Expression('NOW()');
            $identity->save(false);
        }
    }
}
