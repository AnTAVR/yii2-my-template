<?php

namespace app\modules\uploader\models;

use ErrorException;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * Database fields:
 * @property integer $id
 * @property string $file
 * @property string $meta_url
 * @property string $comment
 *
 * Fields:
 * @property string $url
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
            'url' => Yii::t('app', 'File Url'),
            'filePath' => Yii::t('app', 'File Path'),
        ];
    }

    public static function getUploadUrl()
    {
        return Yii::getAlias('@web_upload') . '/' . static::PATH_FILES . '/';
    }

    public static function getUploadPath()
    {
        $path = Yii::getAlias('@upload') . DIRECTORY_SEPARATOR . static::PATH_FILES;
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
    public function getFilePath()
    {
        return static::getUploadPath() . $this->meta_url;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $no_errors = true;

        try {
            unlink($this->filePath);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (ErrorException $e) {
            Yii::error($e);
            $no_errors = !file_exists($this->filePath);
        }

        return $no_errors;
    }
}
