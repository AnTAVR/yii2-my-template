<?php

namespace app\modules\account\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/** @noinspection PropertiesInspection */

/**
 * @property string $authKey
 *
 * Database fields:
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $salt
 *
 * @property string $auth_key
 * @property string $access_token
 *
 * @property boolean $email_confirmed
 *
 * @property string $foto
 *
 * @property integer $status
 *
 * @property integer $created_at
 *
 * @property integer $session_at
 * @property string $session
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 0;
    const STATUS_BLOCKED = 10;
    const STATUS_DELETED = 20;

    static $statusName = [];

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
     * @return static|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        $identity = static::findOne($id);
        if ($identity) {
            $identity->session_at = new Expression('NOW()');
            $identity->save();
        }
        return $identity;
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

    function init()
    {
        parent::init();
        static::$statusName = [
            static::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
            static::STATUS_BLOCKED => Yii::t('app', 'BLOCKED'),
            static::STATUS_DELETED => Yii::t('app', 'DELETED'),
        ];
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
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
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
     */
    public function validatePassword($password)
    {
        $security = Yii::$app->security;
        return $security->validatePassword($password, $this->password_hash);
    }
}
