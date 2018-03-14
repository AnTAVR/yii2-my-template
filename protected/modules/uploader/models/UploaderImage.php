<?php

namespace app\modules\uploader\models;

use Yii;
use yii\db\ActiveRecord;

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
    const PATH_IMAGES = '/upload/images';
    const PATH_THUMBNAIL = '/upload/images/thumbnail';

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

    /**
     * @inheritdoc
     */
    public function getImageUrl()
    {
        return Yii::getAlias('@web' . self::PATH_IMAGES) . '/' . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getImagePath()
    {
        return Yii::getAlias('@webroot' . self::PATH_IMAGES) . '/' . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getThumbnailUrl()
    {
        return Yii::getAlias('@web' . self::PATH_THUMBNAIL) . '/' . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getThumbnailPath()
    {
        return Yii::getAlias('@webroot' . self::PATH_THUMBNAIL) . '/' . $this->meta_url;
    }
}
