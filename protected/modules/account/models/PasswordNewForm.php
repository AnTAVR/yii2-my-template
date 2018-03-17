<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

class PasswordNewForm extends User
{
    public $password;
    public $repeatPassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = require __DIR__ . '/../config/params.php';
        $rules = [
            ['verifyCode', 'captcha'],

            ['password', 'required'],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min']],

            ['repeatPassword', 'required'],
            ['repeatPassword', 'compare',
                'compareAttribute' => 'password'],
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $hints = [
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
        ];

        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }
}
