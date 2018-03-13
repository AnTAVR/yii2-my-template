<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;

class PasswordResetForm extends Model
{
    public $email;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-Mail'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }
}
