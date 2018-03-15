<?php

namespace app\modules\account\models;


use Yii;
use yii\helpers\ArrayHelper;

trait UserTrait
{
    public $id;
    public $username;
    public $email;
    public $password;

    public $verifyRules;
    public $verifyPassword;
    public $oldPassword;
    public $verifyCode;
    public $rememberMe = true;

    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'signup' => ['username', 'password', 'verifyPassword', 'email', 'verifyCode', 'verifyRules'],
                'login' => ['username', 'password', 'verifyCode', 'rememberMe'],
                'password-edit' => ['oldPassword', 'password', 'verifyPassword', 'verifyCode'],
                'password-reset' => ['email', 'verifyCode'],
            ]
        );
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $params = Yii::$app->params;
        $rules = [
            ['username', 'required',
                'on' => ['signup', 'login']],
            ['username', 'string',
                'max' => $params['username.max'],
                'min' => $params['username.min'],
                'on' => ['signup', 'login']],
            ['username', 'match',
                'pattern' => $params['username.pattern'],
                'on' => ['signup', 'login']],
//            ['username', 'unique',
//                'on' => ['signup']],

            ['oldPassword', 'required',
                'on' => ['password-edit']],
            ['oldPassword', 'validateOldPassword',
                'on' => ['password-edit']],

            ['password', 'required',
                'on' => ['signup', 'login', 'password-edit']],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min'],
                'on' => ['signup', 'password-edit']],
            ['password', 'validateLoginPassword',
                'on' => ['login']],

            ['verifyPassword', 'required',
                'on' => ['signup', 'password-edit']],
            ['verifyPassword', 'compare',
                'compareAttribute' => 'password',
                'on' => ['signup', 'password-edit']],

            ['email', 'required',
                'on' => ['signup', 'password-reset']],
            ['email', 'string', 'max' => $params['email.max'],
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

            ['verifyRules', 'compare',
                'compareValue' => 1,
                'message' => Yii::t('app', 'You must agree with the rules'),
                'on' => ['signup']],
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-Mail'),
            'password' => Yii::t('app', 'Password'),
            'oldPassword' => Yii::t('app', 'Old Password'),
            'verifyPassword' => Yii::t('app', 'Verification Password'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
            'verifyRules' => Yii::t('app', 'Verify Rules'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    public function attributeHints()
    {
        $hints = [];

        /** @noinspection PhpUndefinedFieldInspection */
        $scenario = $this->scenario;
        if ($scenario == 'signup') {
            $hints = [
                'username' => Yii::t('app', 'Possible characters ({chars})', ['chars' => Yii::$app->params['username.hint']]),
                'email' => Yii::t('app', 'E-Mail must be valid, a letter with instructions will be sent to it.'),
                'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
            ];
        } elseif ($scenario == 'password-reset') {
            $hints = [
                'email' => Yii::t('app', 'Enter E-Mail corresponding to the account, it will be sent an email with instructions.'),
            ];
        } elseif ($scenario == 'password-edit') {
            $hints = [
                'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
            ];
        }

        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    /**
     * @param $attribute string
     * @param $params array
     * @return bool
     */
    public function validateLoginPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }

    /**
     * @param $attribute string
     * @param $params array
     * @return bool
     */
    public function validateOldPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }
}