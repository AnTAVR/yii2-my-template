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
    const PATH_FILES = 'files';

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
            'fileUrl' => Yii::t('app', 'File Url'),
            'filePath' => Yii::t('app', 'File Path'),
        ];
    }

    public static function getUploadUrl()
    {
        return Yii::getAlias('@web_upload') . '/' . static::PATH_FILES . '/';
    }

    public static function getUploadPath()
    {
        return Yii::getAlias('@upload') . DIRECTORY_SEPARATOR . static::PATH_FILES . DIRECTORY_SEPARATOR;
    }

    /**
     * @inheritdoc
     */
    public function getFileUrl()
    {
        return static::getUploadUrl() . $this->meta_url;
    }

    /**
     * @inheritdoc
     */
    public function getFilePath()
    {
        return static::getUploadPath() . $this->meta_url;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        unlink($this->filePath);

        return true;
    }
}
