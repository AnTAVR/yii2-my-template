<?php

namespace app\modules\account\models;

use yii\base\Model;

class PasswordResetForm extends Model
{
    use UserTrait;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required', 'on' => ['password-reset']],
            ['email', 'email', 'on' => ['password-reset']],
            ['verifyCode', 'captcha', 'on' => ['password-reset']],
        ];
    }

    public function save()
    {
        return true;
    }
}
