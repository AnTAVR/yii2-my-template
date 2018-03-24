<?php

use app\migrations\DefaultContent;
use app\models\StaticPage;
use yii\db\Migration;

class m000101_000002_insert_page_static extends Migration
{
    public $tableName;

    public $content_static = ['index', 'about', 'rules', 'delivery', 'payment', 'partners', 'docs'];

    public function init()
    {
        parent::init();
        $this->tableName = StaticPage::tableName();
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

        foreach ($this->content_static as $title) {
            $this->insert($this->tableName, [
                    'content_title' => $title,
                    'content_full' => str_replace(['{title}', '{style}'], [$title, ' style="float:left"'], $content_full) .
                        str_replace('{style}', ' style="float:right"', $content_short) .
                        str_replace('{image}', '', DefaultContent::CONTENT_SHORT),

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
        foreach ($this->content_static as $title) {
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
