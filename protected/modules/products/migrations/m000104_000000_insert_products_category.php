<?php

use app\migrations\DefaultContent;
use app\modules\products\models\Category;
use yii\db\Migration;

class m000104_000000_insert_products_category extends Migration
{
    const CONTENT_TITLE = 'allproducts';
    const COUNT = 1;
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = Category::tableName();
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
            $style = ' style="float:left"';

            $this->insert($this->tableName, [
                'published_at' => time(),

                'content_title' => $title,
                'content_full' => str_replace(['{title}', '{style}'], [$title, $style], $content_full),

                'meta_url' => $title,
            ]);
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
