<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * LoginForm is the model behind the login form.
 *
 */
class LoginForm extends User
{
    public $password;
    public $rememberMe = true;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->getModule('account')->params;
        $rules = [
            ['verifyCode', 'captcha'],
            ['rememberMe', 'boolean'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string',
                'max' => $params['username.max'],
                'min' => $params['username.min']],
            ['username', 'match',
                'pattern' => $params['username.pattern']],

            ['password', 'required'],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min']],

            ['username', 'exist'],
            ['password', 'validateLoginPassword'],
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
            'rememberMe' => Yii::t('app', 'Remember Me'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $params = Yii::$app->getModule('account')->params;
        $hints = [
            'password' => Html::a(Yii::t('app', 'Password Reset'), ['/account/recovery'], ['class' => 'label label-danger']),
        ];
        if ($params['signup']) {
            $hints['username'] = Html::a(Yii::t('app', 'Signup'), ['/account/signup'], ['class' => 'label label-success']);
        }

        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateLoginPassword($attribute, /** @noinspection PhpUnusedParameterInspection */
                                          $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['username' => $this->username]);
            if ($user) {
                $security = Yii::$app->security;
                if ($security->validatePassword($this->password, $user->password_hash)) {
                    return;
                }
            }
            $this->addError($attribute, Yii::t('app', 'Incorrect password.'));
        }
    }
}
