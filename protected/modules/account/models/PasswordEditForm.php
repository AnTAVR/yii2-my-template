<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

class PasswordEditForm extends User
{
    public $password;
    public $verifyPassword;
    public $oldPassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        $rules = [
            ['verifyCode', 'captcha'],

            ['password', 'required'],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min']],

            ['verifyPassword', 'required'],
            ['verifyPassword', 'compare',
                'compareAttribute' => 'password'],

            ['oldPassword', 'required'],

            ['oldPassword', 'validateOldPassword'],
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
            'oldPassword' => Yii::t('app', 'Old Password'),
            'verifyPassword' => Yii::t('app', 'Verification Password'),
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

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateOldPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }

    /**
     * @return bool
     */
    public function edit()
    {
        return true;
    }
}
