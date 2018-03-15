<?php

namespace app\modules\account\models;

use yii\base\Model;

class PasswordResetForm extends Model
{
    use UserTrait;
    /**
     * @return bool
     */
    public function reset()
    {
        return true;
    }
}
