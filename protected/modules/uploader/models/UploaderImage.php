<?php

namespace app\modules\uploader\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "uploader_image".
 *
 * @property integer $id
 * @property string $file
 * @property string $meta_url
 * @property string $comment
 *
 * @property string $imageUrl
 * @property string $imagePath
 * @property string $thumbnailUrl
 * @property string $thumbnailPath
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
            'imageUrl' => Yii::t('app', 'Image Url'),
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
    public function getImageUrl()
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

        if (is_file($this->thumbnailPath)) {
            unlink($this->thumbnailPath);
        }

        if (is_file($this->imagePath)) {
            unlink($this->imagePath);
        }

        return true;
    }
}
