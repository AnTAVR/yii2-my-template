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
    public $newPassword;
    public $verifyCode;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'required',
                'on' => ['signup', 'login']],
            ['username', 'string', 'max' => Yii::$app->params['username.max'], 'min' => Yii::$app->params['username.min'],
                'on' => ['signup', 'login']],
//            ['username', 'unique',
//                'on' => ['signup']],
            ['password', 'required',
                'on' => ['signup', 'login', 'password-edit']],
            ['password', 'string', 'max' => Yii::$app->params['password.max'], 'min' => Yii::$app->params['password.min'],
                'on' => ['signup', 'login', 'password-edit']],
            ['password', 'validatePassword',
                'on' => ['login']],
            ['verifyPassword', 'required',
                'on' => ['signup', 'password-edit']],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password',
                'on' => ['signup', 'password-edit']],
            ['email', 'required',
                'on' => ['signup', 'password-reset']],
            ['email', 'string', 'max' => Yii::$app->params['username.max'],
                'on' => ['signup', 'password-reset']],
            ['email', 'email',
                'on' => ['signup', 'password-reset']],
//            ['email', 'unique',
//                'on' => ['signup']],
//            ['email', 'exist',
//                'on' => ['password-reset']],
            ['verifyCode', 'captcha',
                'on' => ['signup', 'login', 'password-edit', 'password-reset']],
            ['rememberMe', 'boolean',
                'on' => ['login']],
            ['verifyRules', 'boolean',
                'on' => ['signup']],
            ['verifyRules', 'compare', 'compareValue' => 1, 'message' => Yii::t('app', 'You must agree with the rules'),
                'on' => ['signup']],
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
                'password' => Yii::t('app', 'Задайте сложный пароль, используя заглавные и строчные буквы (A-Z, a-z), цифры (0-9) и специальные символы'),
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
                'password' => Yii::t('app', 'Задайте сложный пароль, используя заглавные и строчные буквы (A-Z, a-z), цифры (0-9) и специальные символы'),
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