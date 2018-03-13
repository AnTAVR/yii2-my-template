<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $verifyPassword;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'verifyPassword'], 'required', 'on' => ['signup']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup']],
            ['verifyCode', 'captcha', 'on' => ['signup']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
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
