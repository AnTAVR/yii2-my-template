<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Database fields:
 * @property int $id [int(11)]
 * @property string $content_title [varchar(255)]
 * @property string $content_full
 * @property string $meta_url [varchar(255)]
 * @property string $meta_description [varchar(255)]
 * @property string $meta_keywords [varchar(255)]
 *
 * Fields:
 * @property string $url
 */
class StaticPage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_static}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['content_title', 'trim'],
            ['content_title', 'required'],
            ['content_title', 'string',
                'max' => 255],

            ['content_full', 'trim'],
            ['content_full', 'required'],
            ['content_full', 'string'],

            ['meta_url', 'trim'],
            ['meta_url', 'required'],
            ['meta_url', 'string',
                'max' => 255],
            ['meta_url', 'match',
                'pattern' => $params['meta_url_pattern']],
            ['meta_url', 'unique'],

            ['meta_description', 'trim'],
            ['meta_description', 'string',
                'max' => 255],

            ['meta_keywords', 'trim'],
            ['meta_keywords', 'string',
                'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_title' => Yii::t('app', 'Content Title'),
            'content_full' => Yii::t('app', 'Content Full'),
            'meta_url' => Yii::t('app', 'Meta Url'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'url' => Yii::t('app', 'Static Url'),

        ];
    }

    public function attributeHints()
    {
        return [
            'meta_url' => Yii::t('app', 'Possible characters ({chars})', ['chars' => Yii::$app->params['meta_url_hint']]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return Url::to(['/static/index', 'meta_url' => $this->meta_url]);
    }
}
