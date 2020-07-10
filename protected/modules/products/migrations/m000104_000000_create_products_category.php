<?php

use app\components\DbHelper;
use app\modules\products\models\Category;
use yii\db\Migration;

class m000104_000000_create_products_category extends Migration
{
    public $tableName;

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function init()
    {
        parent::init();
        $this->tableName = Category::tableName();
    }

    public function up()
    {
        if ($this->db->driverName !== 'mysql') {
            $this->tableOptions = null;
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),

            'published_at' => $this->bigInteger(),

            'content_title' => $this->string()->notNull(),
            'content_full' => $this->text(),

            'meta_url' => $this->string()->notNull()->unique(),
            'meta_description' => $this->string(),
            'meta_keywords' => $this->string(),
        ], $this->tableOptions);

        $name = 'published_at';
        $this->createIndex(DbHelper::indexName($this->tableName, $name), $this->tableName, $name);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
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
