<?php

use yii\db\Migration;

/**
 * Handles the creation for table `page_products`.
 */
class m000104_000001_create_page_products extends Migration
{
    public $tableName = '{{%page_products}}';

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->db->driverName !== 'mysql') {
            $this->tableOptions = null;
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),

            'published_at' => $this->dateTime(),
            'status' => $this->smallInteger()->notNull(),

            'content_title' => $this->string()->notNull(),
            'content_short' => $this->text()->notNull(),
            'content_full' => $this->text()->notNull(),

            'meta_url' => $this->string()->notNull()->unique(),
            'meta_description' => $this->string(),
            'meta_keywords' => $this->string(),
        ], $this->tableOptions);

        $name = 'published_at';
        $this->createIndex($name, $this->tableName, $name);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $name = 'published_at';
        $this->dropIndex($name, $this->tableName);

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
