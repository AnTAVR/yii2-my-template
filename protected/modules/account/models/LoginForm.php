<?php

namespace app\modules\account\models;

use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 */
class LoginForm extends User
{
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
