<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/** @noinspection MissingPropertyAnnotationsInspection */
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
        $identity = static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
        if ($identity) {
            $identity->session_at = new Expression('NOW()');
            $identity->save(false);
        }
        return $identity;
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
        $tokenModel = Token::findOne([
            'code' => $token,
            'type' => Token::TYPE_API_AUTH
        ]);

        if (!$tokenModel or $tokenModel->isExpired) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Auth code not found or expired!'));
        }

        return static::findOne(['id' => $tokenModel->user_id, 'status' => static::STATUS_ACTIVE]);
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
}
