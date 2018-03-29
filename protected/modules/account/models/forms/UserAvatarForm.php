<?php

namespace app\modules\account\models\forms;

use ErrorException;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

//use yii\base\ModelEvent;

/**
 *
 * @property string $avatarPath
 * @property string $avatarUrl
 */
class UserAvatarForm extends Model
{
    const EVENT_BEFORE_UPLOAD = 'beforeUpload';

    const PATH_AVATARS = 'user-avatar';
    const MAX_SIZE = 256 * 1024;
    const EXTENSIONS = 'png, jpg, jpeg, gif';
    const ACCEPT = 'image/jpeg, image/png, image/gif';

    /**
     * @var string
     */
    public $oldAvatar;
    /**
     * @var UploadedFile
     */
    public $fileUpload;
    /**
     * @var integer
     */
    public $user_id;
    /**
     * @var string
     */
    public $avatar;

    public function rules()
    {
//        $params = Yii::$app->params;
        return [
//            ['user_id', 'required'],
//            ['user_id', 'integer'],

//            ['avatar', 'required'],
//            ['avatar', 'string',
//                'max' => $params['string.max']],

            ['fileUpload', 'required'],
            ['fileUpload', 'image',
                'skipOnEmpty' => false,
                'extensions' => self::EXTENSIONS,
                'maxSize' => self::MAX_SIZE,
                'mimeTypes' => self::ACCEPT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'avatar' => Yii::t('app', 'Avatar'),
            'fileUpload' => Yii::t('app', 'Avatar'),
        ];
    }

    public function attributeHints()
    {
        return [
            'fileUpload' => Yii::t('app', 'Max size {size} {bytes}.',
                    ['size' => Yii::$app->formatter->asOrdinal(self::MAX_SIZE), 'bytes' => 'Bytes']) . ' ' .
                Yii::t('app', 'Extensions "{extensions}"', ['extensions' => self::EXTENSIONS]),
        ];
    }

    public function getAvatarUrl()
    {
        return static::getUploadUrl() . $this->avatar;
    }

    public static function getUploadUrl()
    {
        return Yii::getAlias('@web_upload') . '/' . static::PATH_AVATARS . '/';
    }

    public function getAvatarPath()
    {
        return static::getUploadPath() . $this->avatar;
    }

    public static function getUploadPath()
    {
        $path = Yii::getAlias('@upload') . DIRECTORY_SEPARATOR . static::PATH_AVATARS;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0775, true);
        }
        return $path . DIRECTORY_SEPARATOR;
    }

    public function beforeUpload()
    {
//        $event = new ModelEvent();
//        $this->trigger(self::EVENT_BEFORE_UPLOAD, $event);
//
//        return $event->isValid;

        $this->delete();
        return true;
    }

    public function delete()
    {
        $no_errors = true;

        try {
            unlink($this->avatarPath);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (ErrorException $e) {
            Yii::error($e);
            $no_errors = !file_exists($this->avatarPath);
        }

        return $no_errors;
    }

    public function upload()
    {
        $this->fileUpload = UploadedFile::getInstance($this, 'fileUpload');
        if (!$this->validate()) {
            return Json::encode($this->errors);
        }
        $this->avatar = uniqid(time(), true) . '.' . $this->fileUpload->extension;

        if (!$this->beforeUpload()) {
            return false;
        }

        if (!$this->fileUpload->saveAs($this->avatarPath)) {
            return Json::encode($this->fileUpload->error);
        }

        return Json::encode([
            'files' => [[
                'name' => $this->fileUpload->name,
                'size' => $this->fileUpload->size,
                'url' => $this->avatarUrl,
                'deleteUrl' => 'avatar-delete',
                'deleteType' => 'post',
            ]]
        ]);

    }
}
