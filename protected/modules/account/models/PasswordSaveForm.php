<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;

class PasswordSaveForm extends Model
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
            ['password', 'required', 'on' => ['password-save']],
            ['verifyPassword', 'required', 'on' => ['password-save']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['password-save']],
            ['verifyCode', 'captcha', 'on' => ['password-save']],
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
