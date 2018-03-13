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
}