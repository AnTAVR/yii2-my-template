<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/** @noinspection PropertiesInspection */


/**
 * @property integer id
 * @property string username
 * @property string email
 * @property string password_hash
 *
 * @property string auth_key
 * @property string access_token
 *
 * @property boolean email_confirmed
 *
 * @property string foto
 *
 * @property integer status
 *
 * @property integer created_at
 *
 * @property integer session_at
 * @property string session
 *
 * @property string $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    public $verifyRules;
    public $verifyPassword;
    public $oldPassword;
    public $verifyCode;
    public $rememberMe = true;

    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

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
        return [
            ['username', 'required',
                'on' => ['signup', 'login']],
            ['username', 'string',
                'max' => $params['username.max'],
                'min' => $params['username.min'],
                'on' => ['signup', 'login']],
            ['username', 'match',
                'pattern' => $params['username.pattern'],
                'on' => ['signup', 'login']],
            ['username', 'unique',
                'on' => ['signup']],

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
            ['email', 'unique',
                'on' => ['signup']],
            ['email', 'exist',
                'on' => ['password-reset']],

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
            'oldPassword' => Yii::t('app', 'Old Password'),
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

        /** @noinspection PhpUndefinedClassInspection */
        return array_merge(parent::attributeHints(), $hints);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        $security = Yii::$app->security;
        return $this->password_hash === $security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $security = Yii::$app->security;
        $this->auth_key = $security->generateRandomString();
    }

    /**
     * @param string $password password to validate
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $security = Yii::$app->security;
        $this->password_hash = $security->generatePasswordHash($password);
    }

    public function validateLoginPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }

    public function validateOldPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }
}
