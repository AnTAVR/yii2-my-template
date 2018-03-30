<?php

namespace app\modules\account\models\forms;

use app\modules\account\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class RecoveryPasswordNewForm extends User
{
    public $password;
    public $repeatPassword;
    public $verifyCode;

    public function rules()
    {
        $params = Yii::$app->getModule('account')->params;
        return [
            ['verifyCode', 'captcha'],

            ['password', 'required'],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min']],

            ['repeatPassword', 'required'],
            ['repeatPassword', 'compare',
                'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
        ]);
    }
}
