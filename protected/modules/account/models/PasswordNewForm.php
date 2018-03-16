<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property string passwordToken
 */
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
        $params = Yii::$app->params;
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

    /**
     * @return string
     */
    public function passwordTokenRaw()
    {
        return $this->salt . $this->password_hash;
    }

    /**
     * @return string
     */
    public function getPasswordToken()
    {
        return hash('sha256', $this->passwordTokenRaw());
    }

    /**
     * @param string $token
     * @return boolean
     */
    public function validatePasswordToken($token)
    {
        return $token === $this->passwordToken;
    }

    /**
     * @return static|null
     * @throws \yii\base\Exception
     */
    public function edit()
    {
        $ret = null;
        $security = Yii::$app->security;
        $this->password_hash = $security->generatePasswordHash($this->password);
        if ($this->save(false)) {
            $ret = $this;
        }

        return $ret;
    }
}
