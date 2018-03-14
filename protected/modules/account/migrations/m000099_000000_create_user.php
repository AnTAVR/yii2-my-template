<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m000099_000000_create_user extends Migration
{
    public $tableName = '{{%user}}';

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
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'email_confirmed' => $this->boolean()->notNull()->defaultValue(false),

            'foto' => $this->string(),

            'status' => $this->smallInteger()->notNull(),

            'created_at' => $this->dateTime()->defaultValue(new Expression('NOW()')),

            'session_at' => $this->dateTime(),
            'session' => $this->string(),

        ], $this->tableOptions);

        $name = 'session';
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
