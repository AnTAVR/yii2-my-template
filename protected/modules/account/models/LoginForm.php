<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(),
            [
                'login' => ['username', 'password', 'verifyCode', 'rememberMe'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        $rules = [
            ['verifyCode', 'captcha'],
            ['rememberMe', 'boolean'],

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
            'rememberMe' => Yii::t('app', 'Remember Me'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     * @throws \yii\base\Exception
     */
    public function validateLoginPassword($attribute, /** @noinspection PhpUnusedParameterInspection */
                                          $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->validatePassword($this->getAttribute($attribute))) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
}
