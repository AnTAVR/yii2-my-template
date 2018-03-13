<?php

namespace app\modules\account\models;

use yii\base\Model;

class SignupForm extends Model
{
    use UserTrait;

    public function save()
    {
        return true;
    }
}
