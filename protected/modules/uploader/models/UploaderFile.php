<?php

namespace app\modules\uploader\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "uploader_file".
 *
 * @property integer $id
 * @property string $file
 * @property string $meta_url
 * @property string $comment
 *
 * @property string $fileUrl
 * @property string $filePath
 */
class UploaderFile extends ActiveRecord
{
    const PATH_FILES = '/upload/files';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%uploader_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'file', 'meta_url'], 'string', 'max' => 255],
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
            'fileUrl' => Yii::t('app', 'File Url'),
            'filePath' => Yii::t('app', 'File Path'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFileUrl()
    {
        return Yii::getAlias('@web' . self::PATH_FILES) . '/' . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getFilePath()
    {
        return Yii::getAlias('@webroot' . self::PATH_FILES) . '/' . $this->meta_url;
    }
}
