<?php

use app\modules\account\models\User;
use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m000099_000000_create_user extends Migration
{
    public $tableName;

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function init()
    {
        parent::init();
        $this->tableName = User::tableName();
    }

    public function up()
    {
        if ($this->db->driverName !== 'mysql') {
            $this->tableOptions = null;
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'salt' => $this->string(64)->notNull(),

            'auth_key' => $this->string(32)->notNull(),

            'email_confirmed' => $this->boolean()->notNull()->defaultValue(false),

            'avatar' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),

            'created_at' => $this->integer()->notNull(),
            'created_ip' => $this->string(45),

            'last_login_at' => $this->integer(),
            'last_request_at' => $this->integer(),

            'session' => $this->string(),
        ], $this->tableOptions);

        $name = 'session';
        $this->createIndex($name, $this->tableName, $name);
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
