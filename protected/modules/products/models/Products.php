<?php

namespace app\modules\products\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\validators\DateValidator;

/** @noinspection MissingPropertyAnnotationsInspection */
/**
 * This is the model class for table "page_products".
 *
 * @property integer $id
 *
 * @property integer $published_at
 * @property integer $status
 *
 * @property string $content_title
 * @property string $content_short
 * @property string $content_full
 *
 * @property string $meta_url
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property array $arrUrl
 * @property string $productsUrl
 * @property string $status_txt
 */
class Products extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_DRAFT = 10;
    const STATUS_ACTIVE = 20;

    const CONTENT_SHORT_MAX_SIZE = 1024;

    static $statusName = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_products}}';
    }

    function init()
    {
        parent::init();
        self::$statusName = [
            self::STATUS_DELETED => Yii::t('app', 'DELETED'),
            self::STATUS_DRAFT => Yii::t('app', 'DRAFT'),
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
        ];
        $this->status = self::STATUS_DRAFT;
    }

    public function getStatusName()
    {
        return self::$statusName[$this->status];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['published_at', 'trim'],
            ['published_at', 'date',
                'type' => DateValidator::TYPE_DATETIME,
                'format' => 'Y-MM-dd HH:mm:ss'],

            ['content_title', 'trim'],
            ['content_title', 'required'],
            ['content_title', 'string',
                'max' => $params['string.max']],
            ['content_title', 'safe'],

            ['content_short', 'trim'],
            ['content_short', 'required'],
            ['content_short', 'string',
                'max' => self::CONTENT_SHORT_MAX_SIZE],

            ['content_full', 'trim'],
            ['content_full', 'required'],
            ['content_full', 'string'],

            ['meta_description', 'trim'],
            ['meta_description', 'string',
                'max' => $params['string.max']],

            ['meta_keywords', 'trim'],
            ['meta_keywords', 'string',
                'max' => $params['string.max']],

            ['meta_url', 'trim'],
            ['meta_url', 'required'],
            ['meta_url', 'string',
                'max' => $params['string.max']],
            ['meta_url', 'match',
                'pattern' => $params['meta_url_pattern']],
            ['meta_url', 'unique'],

            ['status', 'required'],
            ['status', 'integer'],
            ['status', 'default',
                'value' => self::STATUS_DRAFT],
            ['status', 'in',
                'range' => array_keys(self::$statusName)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),

            'published_at' => Yii::t('app', 'Published At'),
            'status' => Yii::t('app', 'Status'),

            'content_title' => Yii::t('app', 'Title'),
            'content_short' => Yii::t('app', 'Content Short'),
            'content_full' => Yii::t('app', 'Content Full'),

            'meta_url' => Yii::t('app', 'Meta Url'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),

            'status_txt' => Yii::t('app', 'Status'),
            'productsUrl' => Yii::t('app', 'Products Url'),
        ];
    }

    public function attributeHints()
    {
        return [
            'meta_url' => Yii::t('app', 'Possible characters ({chars})', ['chars' => Yii::$app->params['meta_url_hint']]),
            'content_short' => Yii::t('app', 'Max length {length}', ['length' => self::CONTENT_SHORT_MAX_SIZE]),
        ];
    }

    /**
     * @return string
     */
    public function getStatus_txt()
    {
        return isset(self::$statusName[$this->status]) ? self::$statusName[$this->status] : 'None';
    }

    /**
     * @inheritdoc
     */
    public function getArrUrl()
    {
        return ['/products/default/view', 'meta_url' => $this->meta_url];
    }

    /**
     * @inheritdoc
     */
    public function getProductsUrl()
    {
        return Url::to($this->arrUrl);
    }
}
