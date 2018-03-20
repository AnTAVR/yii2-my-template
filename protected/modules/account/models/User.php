<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/** @noinspection MissingPropertyAnnotationsInspection */
/**
 * @property string $authKey
 * @property string $status_txt
 * @property string $tokenPasswordRaw
 * @property string $tokenPassword
 * @property string $tokenEmailRaw
 * @property string $tokenEmail
 *
 * Database fields:
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $salt
 *
 * @property string $auth_key
 *
 * @property boolean $email_confirmed
 *
 * @property string $avatar
 *
 * @property integer $status
 *
 * @property integer $created_at
 * @property integer $created_ip
 *
 * @property integer $last_request_at
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

    function init()
    {
        parent::init();
        static::$statusName = [
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
            self::STATUS_BLOCKED => Yii::t('app', 'BLOCKED'),
            self::STATUS_DELETED => Yii::t('app', 'DELETED'),
        ];
    }

    public function getStatusName()
    {
        return self::$statusName[$this->status];
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
     * @return static|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findUserActive($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null $type
    //     * @return IdentityInterface|null the identity object that matches the given token.
     * @return User|null
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $tokenModel = UserToken::findOne([
            'code' => $token,
            'type' => UserToken::TYPE_API_AUTH
        ]);

        if (!$tokenModel or $tokenModel->isExpired) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Auth code not found or expired!'));
        }

        return static::findUserActive($tokenModel->user_id);
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
            'status_txt' => Yii::t('app', 'Status'),
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
     * @return string
     */
    public function getStatus_txt()
    {
        return isset(self::$statusName[$this->status]) ? self::$statusName[$this->status] : 'None';
    }

    public static function findUserActive($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    public function getTokenPasswordRaw()
    {
        return $this->salt . $this->password_hash;
    }

    public function getTokenPassword()
    {
        return hash('sha256', $this->tokenPasswordRaw);
    }

    public function getTokenEmailRaw()
    {
        return $this->salt . $this->email_confirmed . $this->email;
    }

    public function getTokenEmail()
    {
        return hash('sha256', $this->tokenEmailRaw);
    }
}
