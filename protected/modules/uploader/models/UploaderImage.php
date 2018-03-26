<?php

namespace app\modules\uploader\models;

use ErrorException;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * Database fields:
 * @property int $id [int(11)]
 * @property string $file [varchar(255)]
 * @property string $meta_url [varchar(255)]
 * @property string $comment [varchar(255)]
 *
 * Fields:
 * @property string $imagePath
 * @property string $thumbnailPath
 * @property string $url
 * @property string $thumbnailUrl
 */
class UploaderImage extends ActiveRecord
{
    const PATH_IMAGES = 'images';
    const PATH_THUMBNAIL = 'thumbnail';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%uploader_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['comment', 'string',
                'max' => $params['string.max']],

            ['file', 'string',
                'max' => $params['string.max']],

            ['meta_url', 'string',
                'max' => $params['string.max']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'File'),
            'meta_url' => Yii::t('app', 'Meta Url'),
            'comment' => Yii::t('app', 'Comment'),
            'url' => Yii::t('app', 'Image Url'),
            'imagePath' => Yii::t('app', 'Image Path'),
            'thumbnailUrl' => Yii::t('app', 'Thumbnail Url'),
            'thumbnailPath' => Yii::t('app', 'Thumbnail Path'),
        ];
    }

    public static function getUploadUrl()
    {
        return Yii::getAlias('@web_upload') . '/' . static::PATH_IMAGES . '/';
    }

    public static function getUploadPath()
    {
        $path = Yii::getAlias('@upload') . DIRECTORY_SEPARATOR . static::PATH_IMAGES;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0775, true);
        }
        return $path . DIRECTORY_SEPARATOR;
    }

    public static function getUploadThumbnailUrl()
    {
        return static::getUploadUrl() . self::PATH_THUMBNAIL . '/';
    }

    public static function getUploadThumbnailPath()
    {
        $path = static::getUploadPath() . self::PATH_THUMBNAIL;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0775, true);
        }
        return $path . DIRECTORY_SEPARATOR;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return static::getUploadUrl() . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getImagePath()
    {
        return static::getUploadPath() . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getThumbnailUrl()
    {
        return static::getUploadThumbnailUrl() . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getThumbnailPath()
    {
        return static::getUploadThumbnailPath() . $this->meta_url;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $no_errors = true;

        try {
            unlink($this->thumbnailPath);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (ErrorException $e) {
            Yii::error($e);
            $no_errors = !file_exists($this->thumbnailPath);
        }

        try {
            unlink($this->imagePath);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (ErrorException $e) {
            Yii::error($e);
            $no_errors = !file_exists($this->imagePath) && $no_errors;
        }

        return $no_errors;
    }
}
