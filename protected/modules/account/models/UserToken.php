<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/** @noinspection MissingPropertyAnnotationsInspection */

/**
 * This is the model class for table "user_token".
 *
 * @property bool $isExpired
 *
 * Database fields:
 * @property integer $user_id
 * @property string $code
 * @property integer $type
 * @property integer $created_at
 * @property integer $expires_on
 */
class UserToken extends ActiveRecord
{
    const TYPE_API_AUTH = 0;
    const TYPE_CONFIRM_EMAIL = 2;
    const TYPE_RECOVERY_PASSWORD = 4;

    static $typesName = [];

    function init()
    {
        parent::init();
        self::$typesName = [
            self::TYPE_API_AUTH => Yii::t('app', 'API AUTH'),
            self::TYPE_CONFIRM_EMAIL => Yii::t('app', 'CONFIRM EMAIL'),
            self::TYPE_RECOVERY_PASSWORD => Yii::t('app', 'RECOVERY PASSWORD'),
        ];
    }

    /** @noinspection PhpUndefinedClassInspection */

    public function getStatusName()
    {
        return self::$typesName[$this->type];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'integer'],

            ['code', 'required'],
            ['code', 'string',
                'max' => 64],

            ['type', 'required'],
            ['type', 'integer'],

            ['expires_on', 'required'],
            ['expires_on', 'integer'],

            ['code', 'unique',
                'targetAttribute' => ['user_id', 'code', 'type'],
                'message' => Yii::t('app', 'The combination of User ID, Code and Type has already been taken.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'code' => Yii::t('app', 'Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'type' => Yii::t('app', 'Type'),
            'expires_on' => Yii::t('app', 'Expires On'),
        ];
    }

    /**
     * Defining composite primary key
     * @param bool $asArray
     * @return array
     */
    public function getPrimaryKey($asArray = false)
    {
        return ['user_id', 'code', 'type'];
    }

    /** @noinspection PhpUndefinedClassInspection */
    /**
     * Finds a token with user by the token's code.
     *
     * @param string $code
     * @param integer $type The type of the token
     * @return static
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function findByCode($code, $type = self::TYPE_API_AUTH)
    {
        $token = static::findOne(['code' => $code, 'type' => $type]);

        if (!$token) {
            throw new NotFoundHttpException(Yii::t('app', 'Token not found!'));
        }

        if ($token->isExpired) {
            $token->delete();
            throw new NotFoundHttpException(Yii::t('app', 'Token not found!'));
        }

        return $token;
    }

    /**
     * @return bool
     */
    public function getIsExpired()
    {
        return ($this->expires_on > 0) and ($this->expires_on < time());
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getExpiresTxt()
    {
        if ($this->expires_on > 0) {
            return Yii::$app->formatter->asDatetime($this->expires_on);
        }
        return Yii::t('app', 'indefinitely');
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatedTxt()
    {
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

    /**
     * @param integer $userId
     * @param string $code
     * @param integer $expiresOn
     * @return static|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function createApiAuthToken($userId, $code, $expiresOn)
    {
        $token = Yii::createObject([
            'class' => static::class,
            'user_id' => $userId,
            'type' => self::TYPE_API_AUTH,
            'code' => $code,
            'expires_on' => $expiresOn,
        ]);
        return $token->save(false) ? $token : null;
    }

    public static function createConfirmEmailToken($userId, $code)
    {
        $params = Yii::$app->getModule('account')->params;
        $token = Yii::createObject([
            'class' => static::class,
            'user_id' => $userId,
            'type' => self::TYPE_CONFIRM_EMAIL,
            'code' => $code,
            'expires_on' => time() + $params['expires_confirm_email'],
        ]);
        return $token->save(false) ? $token : null;
    }

}