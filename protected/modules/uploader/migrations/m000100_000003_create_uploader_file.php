<?php

use app\components\DbHelper;
use app\modules\uploader\models\UploaderFile;
use yii\db\Migration;

/**
 * Handles the creation for table `uploader_file`.
 */
class m000100_000003_create_uploader_file extends Migration
{
    public $tableName;

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function init()
    {
        parent::init();
        $this->tableName = UploaderFile::tableName();
    }

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
        $this->createIndex(DbHelper::indexName($this->tableName, $name), $this->tableName, $name);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
