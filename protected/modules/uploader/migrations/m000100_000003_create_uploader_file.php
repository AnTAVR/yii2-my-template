<?php

use yii\db\Migration;

/**
 * Handles the creation for table `uploader_file`.
 */
class m000100_000003_create_uploader_file extends Migration
{
    public $tableName = '{{%uploader_file}}';

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
            'file' => $this->string()->notNull(),
            'meta_url' => $this->string()->notNull(),
            'comment' => $this->string(),
        ], $this->tableOptions);

        $name = 'file';
        $this->createIndex($name, $this->tableName, $name);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $name = 'file';
        $this->dropIndex($name, $this->tableName);

        $this->dropTable($this->tableName);
    }
}
