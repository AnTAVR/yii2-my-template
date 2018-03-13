<?php

namespace app\modules\account\models;

use yii\base\Model;

class PasswordEditForm extends Model
{
    use UserTrait;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'required', 'on' => ['password-edit']],
            ['verifyPassword', 'required', 'on' => ['password-edit']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['password-edit']],
            ['verifyCode', 'captcha', 'on' => ['password-edit']],
        ];
    }

    public function save()
    {
        return true;
    }
}
