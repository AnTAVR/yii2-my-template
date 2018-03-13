<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['verifyCode', 'captcha'],
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
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }
}
