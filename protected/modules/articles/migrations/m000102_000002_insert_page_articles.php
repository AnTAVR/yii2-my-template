<?php

use app\migrations\DefaultContent;
use yii\db\Expression;
use yii\db\Migration;

class m000102_000002_insert_page_articles extends Migration
{
    public $tableName = '{{%page_articles}}';

    const CONTENT_TITLE = 'article';
    const COUNT = 3;

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
            $style = '';

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
