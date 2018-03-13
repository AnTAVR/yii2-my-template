<?php

namespace app\modules\account\models;


use Yii;

trait UserTrait
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $verifyPassword;
    public $verifyCode;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['username', 'required', 'on' => ['signup', 'login']],
            ['username', 'unique', 'on' => ['signup']],
            ['password', 'required', 'on' => ['signup', 'login', 'password-edit']],
            ['password', 'validatePassword', 'on' => ['login']],
            ['verifyPassword', 'required', 'on' => ['signup', 'password-edit']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup', 'password-edit']],
            ['email', 'required', 'on' => ['signup', 'password-reset']],
            ['email', 'email', 'on' => ['signup', 'password-reset']],
            ['email', 'unique', 'on' => ['signup']],
            ['verifyCode', 'captcha', 'on' => ['signup', 'login', 'password-edit', 'password-reset']],
            ['rememberMe', 'boolean', 'on' => ['login']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-Mail'),
            'password' => Yii::t('app', 'Password'),
            'verifyPassword' => Yii::t('app', 'Verification Password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
        ];
    }

    public function validatePassword($attribute, $params)
    {
    }
}