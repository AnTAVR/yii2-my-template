<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "page_static".
 *
 * @property integer $id
 * @property string $content_title
 * @property string $content_full
 * @property string $meta_url
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property string $staticUrl
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
        return [
            [['content_title', 'content_full', 'meta_url', 'meta_description', 'meta_keywords'], 'trim'],

            [['content_title', 'content_full', 'meta_url'], 'required'],
            [['content_full'], 'string'],
            [['content_title', 'meta_url', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],

            ['meta_url', 'match', 'pattern' => Yii::$app->params['meta_url_pattern']],
            [['meta_url'], 'unique'],
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
            'staticUrl' => Yii::t('app', 'Static Url'),

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
    public function getStaticUrl()
    {
        return Url::to(['/static/index', 'meta_url' => $this->meta_url]);
    }
}
