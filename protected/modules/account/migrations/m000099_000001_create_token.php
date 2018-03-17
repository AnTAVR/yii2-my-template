<?php

use app\modules\account\models\Token;
use app\modules\account\models\User;
use yii\db\Migration;


class m000099_000001_create_token extends Migration
{
    public $tableName;

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function init()
    {
        parent::init();
        $this->tableName = Token::tableName();
    }

    public function up()
    {
        if ($this->db->driverName !== 'mysql') {
            $this->tableOptions = null;
        }

        $this->createTable($this->tableName, [
            'user_id' => $this->integer()->notNull(),
            'code' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('NOW()'),
            'expires_on' => $this->timestamp()->notNull()->defaultValue(0),
        ], $this->tableOptions);
        $this->createIndex('token_unique', $this->tableName, ['user_id', 'code', 'type'], true);
        $this->addForeignKey('fk_user_token', $this->tableName, 'user_id', User::tableName(), 'id', 'CASCADE', 'RESTRICT');
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
