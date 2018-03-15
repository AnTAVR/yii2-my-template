<?php

namespace app\modules\account\models;

use yii\base\Model;

class PasswordEditForm extends Model
{
    use UserTrait;
    /**
     * @return bool
     */
    public function edit()
    {
        return true;
    }
}
