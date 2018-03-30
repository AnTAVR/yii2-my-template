<?php

namespace app\modules\account\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * Database fields:
 * @property int $id [int(11)]
 * @property string $username [varchar(255)]
 * @property string $email [varchar(255)]
 * @property string $password_hash [varchar(255)]
 * @property string $salt [varchar(64)]
 * @property string $auth_key [varchar(32)]
 * @property bool $email_confirmed [tinyint(1)]
 * @property string $avatar [varchar(255)]
 * @property int $status [smallint(6)]
 * @property int $created_at [int(11)]
 * @property string $created_ip [varchar(45)]
 * @property int $last_login_at [int(11)]
 * @property int $last_request_at [int(11)]
 * @property string $session [varchar(255)]
 *
 * Fields:
 * @property string $authKey
 * @property string $tokenEmailRaw
 * @property string $tokenPassword
 * @property string $tokenEmail
 * @property string $tokenPasswordRaw
 * @property string $statusName
 * @property string $rolesTxt
 * @property string $status_txt
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 0;
    const STATUS_BLOCKED = 10;
    const STATUS_DELETED = 20;

    static $statusNames = [];

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

    public static function findUserActive($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null $type
     * @return static|null the identity object that matches the given token.
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $tokenModel = UserToken::findOne([
            'code' => $token,
            'type' => UserToken::TYPE_API_AUTH
        ]);

        if (!$tokenModel || $tokenModel->isExpired) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Auth code not found or expired!'));
        }

        return static::findUserActive($tokenModel->user_id);
    }

    /**
     * @param string $value
     * @throws \yii\base\Exception
     */
    public function generatePassword($value)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($value);
    }

    function init()
    {
        parent::init();
        static::$statusNames = [
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
            self::STATUS_BLOCKED => Yii::t('app', 'BLOCKED'),
            self::STATUS_DELETED => Yii::t('app', 'DELETED'),
        ];
        if ($this->isNewRecord) {
            $security = Yii::$app->security;
            if (empty($this->salt)) {
                $this->salt = $security->generateRandomString(64);
            }
            if (empty($this->auth_key)) {
                $this->auth_key = $security->generateRandomString();
            }
            if (empty($this->email_confirmed)) {
                $this->email_confirmed = (int)false;
            }
            if (empty($this->status)) {
                $this->status = self::STATUS_ACTIVE;
            }
        }

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
            [
                'class' => 'app\behaviors\IpBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_ip'],
                ],
            ],
        ];
    }

    public function getStatusName()
    {
        return self::$statusNames[$this->status];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-Mail'),
            'status_txt' => Yii::t('app', 'Status'),
            'roles' => Yii::t('app', 'Roles'),
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::$statusNames)],
        ];
    }

    /**
     * @return int current user ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
//        return $this->id;
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
        return isset(self::$statusNames[$this->status]) ? self::$statusNames[$this->status] : 'None';
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

    public function getRolesTxt()
    {
        $authManager = Yii::$app->authManager;
        $roles = [];
        foreach ($authManager->getRolesByUser($this->id) as $role) {
            $roles[] = Html::tag('span', $role->name, ['title' => $role->description]);
        }
        return $roles ? implode(', ', $roles) : null;
    }
}
