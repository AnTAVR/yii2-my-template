<?php

namespace app\modules\uploader\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 *  UploaderFile form
 */
class UploaderFileForm extends Model
{
    const MAX_SIZE = 1 * 1024 * 1024;
    /**
     * @var UploadedFile
     */
    public $fileUpload;
    public $comment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['comment', 'string',
                'max' => $params['string.max']],

            ['fileUpload', 'file',
                'skipOnEmpty' => false,
                'maxSize' => self::MAX_SIZE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment' => Yii::t('app', 'Comment'),
            'fileUpload' => Yii::t('app', 'File'),
        ];
    }

    public function attributeHints()
    {
        return [
            'fileUpload' => Yii::t('app', 'Max size {size} {bytes}.',
                ['size' => Yii::$app->formatter->asOrdinal(self::MAX_SIZE), 'bytes' => 'Bytes']),
        ];
    }

    public function upload()
    {
        $this->fileUpload = UploadedFile::getInstance($this, 'fileUpload');
        if (!$this->validate()) {
            return Json::encode($this->errors);
        }

        $modelFile = new UploaderFile([
            'comment' => $this->comment,
            'file' => $this->fileUpload->name,
            'meta_url' => uniqid(time(), true) . '.' . $this->fileUpload->extension,
        ]);
        if (!$modelFile->save()) {
            return Json::encode($modelFile->errors);
        }

        if (!$this->fileUpload->saveAs($modelFile->filePath)) {
            return Json::encode($this->fileUpload->error);
        }

        return Json::encode([
            'files' => [[
                'name' => $this->fileUpload->name,
                'size' => $this->fileUpload->size,
                'url' => $modelFile->fileUrl,
                'deleteUrl' => 'delete?id=' . $modelFile->id,
                'deleteType' => 'POST'
            ]]
        ]);

    }
}
