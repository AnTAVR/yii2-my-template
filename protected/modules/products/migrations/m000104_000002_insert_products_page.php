<?php

use app\migrations\DefaultContent;
use app\modules\products\models\Products;
use yii\db\Migration;

class m000104_000002_insert_products_page extends Migration
{
    public $tableName;

    const CONTENT_TITLE = 'product';
    const COUNT = 300;

    public function init()
    {
        parent::init();
        $this->tableName = Products::tableName();
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
                'category_id' => rand(1, 3),
                'status' => Products::STATUS_ACTIVE,

                'content_title' => $title,
                'content_short' => str_replace('{style}', $style, $content_short),
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
