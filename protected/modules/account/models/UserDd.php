<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/** @noinspection PropertiesInspection */


/**
 * @property string $authKey
 * @property string auth_key
 */
class UserDd extends ActiveRecord implements IdentityInterface
{
    use UserTrait;

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
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
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
        return $this->password === $password;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function beforeSave($insert)
    {
        $security = Yii::$app->security;
        if ($this->isNewRecord) {
            $this->auth_key = $security->generateRandomString();
        }

        if (!empty($this->password)) {
            $this->password = $security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }
}
