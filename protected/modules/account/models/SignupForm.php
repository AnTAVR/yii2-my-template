<?php

namespace app\modules\account\models;

use yii\base\Model;

class SignupForm extends Model
{
    use UserTrait;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['username', 'required', 'on' => ['signup']],
            ['password', 'required', 'on' => ['signup']],
            ['verifyPassword', 'required', 'on' => ['signup']],
            ['email', 'required', 'on' => ['signup']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup']],
            ['email', 'email', 'on' => ['signup']],
            ['email', 'unique', 'on' => ['signup']],
            ['verifyCode', 'captcha', 'on' => ['signup']],
        ];
    }

    public function save()
    {
        return true;
    }
}
