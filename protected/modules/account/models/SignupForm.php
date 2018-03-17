<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 *
 * @property string $tokenRaw
 * @property mixed $token
 */
class SignupForm extends User
{
    public $password;
    public $repeatPassword;
    public $verifyRules;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = require __DIR__ . '/../config/params.php';
        $rules = [
            ['verifyCode', 'captcha'],

            ['verifyRules', 'boolean'],
            ['verifyRules', 'compare',
                'compareValue' => 1,
                'message' => Yii::t('app', 'You must agree with the rules')],

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

            ['repeatPassword', 'required'],
            ['repeatPassword', 'compare',
                'compareAttribute' => 'password'],

            ['email', 'required'],
            ['email', 'string',
                'max' => Yii::$app->params['email.max']],
            ['email', 'email'],

            ['username', 'unique'],
            ['email', 'unique'],
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
            'verifyRules' => Yii::t('app', 'Verify Rules'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $params = require __DIR__ . '/../config/params.php';
        $hints = [
            'username' => Yii::t('app', 'Possible characters ({chars})', ['chars' => $params['username.hint']]),
            'email' => Yii::t('app', 'E-Mail must be valid, a letter with instructions will be sent to it.'),
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
        ];
        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    public function getTokenRaw()
    {
        return $this->salt . $this->email_confirmed . $this->email;
    }

    public function getToken()
    {
        return hash('sha256', $this->tokenRaw);
    }
}
