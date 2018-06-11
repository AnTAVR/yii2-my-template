<?php

use app\components\DbHelper;
use app\modules\account\models\User;
use app\modules\account\models\UserToken;
use yii\db\Migration;


class m000099_000001_create_token extends Migration
{
    public $tableName;

    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function init()
    {
        parent::init();
        $this->tableName = UserToken::tableName();
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
            'created_at' => $this->integer()->notNull(),
            'expires_on' => $this->integer()->notNull()->defaultValue(0),
        ], $this->tableOptions);

        $name = 'token_unique';
        $this->createIndex(DbHelper::indexKeyName($this->tableName, $name), $this->tableName, ['user_id', 'code', 'type'], true);

        $name = 'user_id';
        $this->addForeignKey(DbHelper::foreignKeyName($this->tableName, $name), $this->tableName, $name, User::tableName(), 'id', 'CASCADE', 'RESTRICT');
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
