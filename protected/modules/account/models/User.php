<?php

namespace app\modules\account\models;

use Yii;
use yii\base\NotSupportedException;
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
    public $verifyPassword;
    public $oldPassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        $rules = [
            ['oldPassword', 'required',
                'on' => ['password-edit']],
            ['oldPassword', 'validateOldPassword',
                'on' => ['password-edit']],

            ['password', 'required',
                'on' => ['password-edit']],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min'],
                'on' => ['password-edit']],

            ['verifyPassword', 'required',
                'on' => ['password-edit']],
            ['verifyPassword', 'compare',
                'compareAttribute' => 'password',
                'on' => ['password-edit']],

            ['verifyCode', 'captcha',
                'on' => ['password-edit']],
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
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $hints = [];

        $scenario = $this->scenario;
        if ($scenario == 'password-edit') {
            $hints = [
                'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
            ];
        }

        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    /**
     * @return string
     */
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
    //     * @return IdentityInterface|null the identity object that matches the given token.
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Method "' . __CLASS__ . '::' . __METHOD__ . '" is not implemented.');
//        return static::findOne(['access_token' => $token]);
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

    /**
     * @throws \yii\base\Exception
     */
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

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateOldPassword(/** @noinspection PhpUnusedParameterInspection */
        $attribute, $params)
    {
        return false;
    }

//    /**
//     * @param bool $insert
//     * @return bool
//     * @throws \yii\base\Exception
//     */
//    public function beforeSave($insert)
//    {
//        $security = Yii::$app->security;
//        if ($insert) {
//            $this->setAttribute('auth_key', $security->generateRandomString());
//        }
//        if (!empty($this->password)) {
//            $this->setPassword($this->password);
//        }
//        return parent::beforeSave($insert);
//    }
}
