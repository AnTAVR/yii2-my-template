<?php

namespace app\modules\news\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Database fields:
 * @property int $id [int(11)]
 * @property int $published_at [int(11)]
 * @property int $status [smallint(6)]
 * @property string $content_title [varchar(255)]
 * @property string $content_short
 * @property string $content_full
 * @property string $meta_url [varchar(255)]
 * @property string $meta_description [varchar(255)]
 * @property string $meta_keywords [varchar(255)]
 * @property int $view_count [int(11)]
 *
 * Fields:
 * @property string $statusName
 * @property null|string|int $published
 * @property string $url
 * @property string $status_txt
 * @property array $arrUrl
 */
class News extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_DRAFT = 10;
    const STATUS_ACTIVE = 20;

    const CONTENT_SHORT_MAX_SIZE = 1024;

    static $statusNames = [];

    public static function tableName()
    {
        return '{{%page_news}}';
    }

    function init()
    {
        parent::init();
        self::$statusNames = [
            self::STATUS_DELETED => Yii::t('app', 'DELETED'),
            self::STATUS_DRAFT => Yii::t('app', 'DRAFT'),
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
        ];
        if (empty($this->status)) {
            $this->status = self::STATUS_DRAFT;
        }
    }

    public function getStatusName()
    {
        return self::$statusNames[$this->status];
    }

    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['published', 'trim'],
            ['published', 'datetime'],

            ['content_title', 'trim'],
            ['content_title', 'required'],
            ['content_title', 'string',
                'max' => $params['string.max']],

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
                'range' => array_keys(self::$statusNames)],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),

            'published_at' => Yii::t('app', 'Published At'),
            'published' => Yii::t('app', 'Published At'),
            'status' => Yii::t('app', 'Status'),

            'content_title' => Yii::t('app', 'Title'),
            'content_short' => Yii::t('app', 'Content Short'),
            'content_full' => Yii::t('app', 'Content Full'),

            'meta_url' => Yii::t('app', 'Meta Url'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),

            'status_txt' => Yii::t('app', 'Status'),
            'url' => Yii::t('app', 'News Url'),
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
     * @return int|string|null
     * @throws InvalidConfigException
     */
    public function getPublished()
    {
        return $this->published_at ? Yii::$app->formatter->asDatetime($this->published_at) : $this->published_at;
    }

    /**
     * @param string|null $value
     */
    public function setPublished($value)
    {
        $this->published_at = $value ? Yii::$app->formatter->asTimestamp($value) : $value;
    }

    /**
     * @return string
     */
    public function getStatus_txt()
    {
        return isset(self::$statusNames[$this->status]) ? self::$statusNames[$this->status] : 'None';
    }

    public function getArrUrl()
    {
        return ['/news/default/view', 'meta_url' => $this->meta_url];
    }

    public function getUrl()
    {
        return Url::to($this->arrUrl);
    }
}
