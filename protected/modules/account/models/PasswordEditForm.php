<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;

class PasswordEditForm extends Model
{
    public $password;
    public $verifyPassword;
    public $verifyCode;

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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'verifyPassword' => Yii::t('app', 'Verification Password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    public function save()
    {
        return true;
    }
}
