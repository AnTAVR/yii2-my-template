<?php

namespace app\modules\account\models;

use Yii;
use yii\db\Expression;
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
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
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
            if (!$user or !$user->validatePassword($this->password)) {
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
        $model = User::findOne(['username' => $this->username]);
        /** @var \app\modules\account\Module $module */
        $module = Yii::$app->getModule('account');
        $login = Yii::$app->user->login($model, $this->rememberMe ? $module->params['duration'] : 0);
        if ($login) {
            $model->session = Yii::$app->session->id;
            $model->session_at = new Expression('NOW()');
            $model->save();
        }
        return $login;
    }
}
