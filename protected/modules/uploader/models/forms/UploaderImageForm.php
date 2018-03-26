<?php

namespace app\modules\uploader\models\forms;

use app\modules\uploader\models\UploaderImage;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 *  UploaderImage form
 */
class UploaderImageForm extends Model
{
    const MAX_SIZE = 1 * 1024 * 1024;
    const EXTENSIONS = 'png, jpg, jpeg, gif';
    const ACCEPT = 'image/jpeg, image/png, image/gif';
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

            ['fileUpload', 'image',
                'skipOnEmpty' => false,
                'extensions' => self::EXTENSIONS,
                'maxSize' => self::MAX_SIZE,
                'mimeTypes' => self::ACCEPT],
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
                    ['size' => Yii::$app->formatter->asOrdinal(self::MAX_SIZE), 'bytes' => 'Bytes']) . ' ' .
                Yii::t('app', 'Extensions "{extensions}"', ['extensions' => self::EXTENSIONS]),
        ];
    }

    public function upload()
    {
        $this->fileUpload = UploadedFile::getInstance($this, 'fileUpload');
        if (!$this->validate()) {
            return Json::encode($this->errors);
        }

        $modelImage = new UploaderImage([
            'comment' => $this->comment,
            'file' => $this->fileUpload->name,
            'meta_url' => uniqid(time(), true) . '.' . $this->fileUpload->extension,
        ]);
        if (!$modelImage->save()) {
            return Json::encode($modelImage->errors);
        }

        if (!$this->fileUpload->saveAs($modelImage->imagePath)) {
            return Json::encode($this->fileUpload->error);
        }

        $this->generateImageThumb($modelImage->imagePath, $modelImage->thumbnailPath);

        return Json::encode([
            'files' => [[
                'name' => $this->fileUpload->name,
                'size' => $this->fileUpload->size,
                'url' => $modelImage->url,
                'thumbnailUrl' => $modelImage->thumbnailUrl,
                'deleteUrl' => 'delete?id=' . $modelImage->id,
                'deleteType' => 'POST'
            ]]
        ]);

    }

    protected function generateImageThumb($path, $thumbPath, $width = 200, $quality = 90)
    {
        $mode = ManipulatorInterface::THUMBNAIL_INSET;

        $image = Image::getImagine()->open($path);
        $imageWidth = $image->getSize()->getWidth();
        $imageHeight = $image->getSize()->getHeight();

        $ratio = $imageWidth / $imageHeight;
        $height = ceil($width / $ratio);

        // Fix error "PHP GD Allowed memory size exhausted".
        ini_set('memory_limit', '512M');
        Image::thumbnail($path, $width, $height, $mode)->save($thumbPath, ['quality' => $quality]);
    }
}
