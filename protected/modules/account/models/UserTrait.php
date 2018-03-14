<?php

namespace app\modules\account\models;


use Yii;

trait UserTrait
{
    public $id;
    public $username;
    public $email;
    public $password;

    public $verifyRules;
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
//            ['username', 'unique', 'on' => ['signup']],
            ['password', 'required', 'on' => ['signup', 'login', 'password-edit']],
            ['password', 'validatePassword', 'on' => ['login']],
            ['verifyPassword', 'required', 'on' => ['signup', 'password-edit']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup', 'password-edit']],
            ['email', 'required', 'on' => ['signup', 'password-reset']],
            ['email', 'email', 'on' => ['signup', 'password-reset']],
//            ['email', 'unique', 'on' => ['signup']],
            ['verifyCode', 'captcha', 'on' => ['signup', 'login', 'password-edit', 'password-reset']],
            ['rememberMe', 'boolean', 'on' => ['login']],
            ['verifyRules', 'boolean', 'on' => ['signup']],
            ['verifyRules', 'compare', 'compareValue' => 1, 'message' => Yii::t('app', 'You must agree with the rules'), 'on' => ['signup']],
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
            'verifyRules' => Yii::t('app', 'Verify Rules'),
        ];
    }

    public function attributeHints()
    {
        $hints = [];

        $scenario = $this->scenario;
        if ($scenario == 'signup') {
            $hints = [
                'username' => Yii::t('app', 'Username'),
                'email' => Yii::t('app', 'E-Mail'),
                'password' => Yii::t('app', 'Password'),
                'verifyPassword' => Yii::t('app', 'Verification Password'),
            ];
        }
        elseif ($scenario == 'login') {
            $hints = [];
        }
        elseif ($scenario == 'password-reset') {
            $hints = [
                'email' => Yii::t('app', 'E-Mail'),
            ];
        }
        elseif ($scenario == 'password-edit') {
            $hints = [
                'password' => Yii::t('app', 'Password'),
                'verifyPassword' => Yii::t('app', 'Verification Password'),
            ];
        }

//        $hints = [
//            'username' => Yii::t('app', 'Username'),
//            'email' => Yii::t('app', 'E-Mail'),
//            'password' => Yii::t('app', 'Password'),
//            'verifyPassword' => Yii::t('app', 'Verification Password'),
//            'verifyCode' => Yii::t('app', 'Verification Code'),
//            'rememberMe' => Yii::t('app', 'Remember Me'),
//            'verifyRules' => Yii::t('app', 'Verify Rules'),
//        ];
        return array_merge(parent::attributeHints(), $hints);
    }

    public function validatePassword($attribute, $params)
    {
    }
}