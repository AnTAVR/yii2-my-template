<?php

use app\migrations\DefaultContent;
use app\modules\articles\models\Articles;
use yii\db\Migration;

class m000102_000002_insert_page_articles extends Migration
{
    const CONTENT_TITLE = 'article';
    const COUNT = 3;

    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = Articles::tableName();
    }

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
            $model = new Articles([
                'published_at' => time(),
                'status' => Articles::STATUS_ACTIVE,

                'content_title' => $title,
                'content_short' => str_replace('{style}', $style, $content_short),
                'content_full' => str_replace(['{title}', '{style}'], [$title, $style], $content_full),

                'meta_url' => $title,
            ]);
            $model->save(false);
        }
    }

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
