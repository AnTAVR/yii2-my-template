<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

class SignupForm extends User
{
    public $password;
    public $verifyPassword;
    public $verifyRules;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
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

            ['verifyPassword', 'required'],
            ['verifyPassword', 'compare',
                'compareAttribute' => 'password'],

            ['email', 'required'],
            ['email', 'string', 'max' => $params['email.max']],
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
            'verifyPassword' => Yii::t('app', 'Verification Password'),
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
        $hints = [
            'username' => Yii::t('app', 'Possible characters ({chars})', ['chars' => Yii::$app->params['username.hint']]),
            'email' => Yii::t('app', 'E-Mail must be valid, a letter with instructions will be sent to it.'),
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
        ];
        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        $ret = null;
        $security = Yii::$app->security;
        $this->password_hash = $security->generatePasswordHash($this->password);
        $this->auth_key = $security->generateRandomString();
        $this->access_token = $security->generateRandomString(40);

        if ($this->save(false)) {
            $ret = $this;
        }

//  the following three lines were added:
//            $auth = Yii::$app->authManager;
//            $authorRole = $auth->getRole('author');
//            $auth->assign($authorRole, $user->getId());

        return $ret;
    }

    /**
     * @return bool
     */
    public function sendEmail()
    {
        return false;
    }
}
