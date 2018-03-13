<?php

namespace app\modules\account\models;

use yii\base\Model;

class PasswordEditForm extends Model
{
    use UserTrait;

    public function save()
    {
        return true;
    }
}
