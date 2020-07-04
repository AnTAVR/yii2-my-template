<?php /** @noinspection PhpUndefinedClassInspection */

namespace app\modules\account\models;

use Exception;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;


/**
 * Database fields:
 * @property int $user_id [int(11)]
 * @property string $code [varchar(64)]
 * @property int $type [smallint(6)]
 * @property int $created_at [int(11)]
 * @property int $expires_on [int(11)]
 *
 * Fields:
 * @property string $expiresTxt
 * @property mixed $statusName
 * @property string $createdTxt
 * @property bool $isExpired
 */
class UserToken extends ActiveRecord
{
    const TYPE_API_AUTH = 0;
    const TYPE_CONFIRM_EMAIL = 2;
    const TYPE_RECOVERY_PASSWORD = 4;

    static $typesNames = [];

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * Finds a token with user by the token's code.
     *
     * @param string $code
     * @param integer $type The type of the token
     * @return static
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
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
     * @param integer $userId
     * @param string $code
     * @param integer $expiresOn
     * @return UserToken|object|null
     * @throws InvalidConfigException
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

    /**
     * @param integer $userId
     * @param string $code
     * @return UserToken|object|null
     * @throws InvalidConfigException
     */
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

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    function init()
    {
        parent::init();
        self::$typesNames = [
            self::TYPE_API_AUTH => Yii::t('app', 'API AUTH'),
            self::TYPE_CONFIRM_EMAIL => Yii::t('app', 'CONFIRM EMAIL'),
            self::TYPE_RECOVERY_PASSWORD => Yii::t('app', 'RECOVERY PASSWORD'),
        ];
    }

    public function getStatusName()
    {
        return self::$typesNames[$this->type];
    }

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

    /**
     * @return bool
     */
    public function getIsExpired()
    {
        return ($this->expires_on > 0) && ($this->expires_on < time());
    }

    /**
     * @return string
     * @throws InvalidConfigException
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
     * @throws InvalidConfigException
     */
    public function getCreatedTxt()
    {
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

}
