<?php

use app\migrations\DefaultContent;
use app\modules\news\models\News;
use yii\db\Expression;
use yii\db\Migration;

class m000103_000002_insert_page_news extends Migration
{
    public $tableName;

    const CONTENT_TITLE = 'new';
    const COUNT = 3;

    public function init()
    {
        parent::init();
        $this->tableName = News::tableName();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $content_short = str_replace('{image}', DefaultContent::CONTENT_IMAGE, DefaultContent::CONTENT_SHORT);
        $content_full = str_replace(['{short}', '{full}'], [
            str_replace('{image}', '', DefaultContent::CONTENT_SHORT),
            $content_short,
        ], DefaultContent::CONTENT_FULL);

        for ($i = 0; $i++ < self::COUNT;) {
            $title = self::CONTENT_TITLE . $i;
            $style = ' style="float:right"';

            $this->insert($this->tableName, [
                    'published_at' => new Expression('NOW()'),
                    'status' => 20,

                    'content_title' => $title,
                    'content_short' => str_replace('{style}', $style, $content_short),
                    'content_full' => str_replace(['{title}', '{style}'], [$title, $style], $content_full),

                    'meta_url' => $title,
                ]
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        for ($i = 0; $i++ < self::COUNT;) {
            $title = self::CONTENT_TITLE . $i;
            $this->delete($this->tableName, ['meta_url' => $title]);
        }
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
