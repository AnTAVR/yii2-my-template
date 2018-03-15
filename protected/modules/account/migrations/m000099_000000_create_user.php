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
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'salt' => $this->string(64)->notNull(),

            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull()->unique(),

            'email_confirmed' => $this->boolean()->notNull()->defaultValue(false),

            'foto' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(0),

            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),

            'session_at' => $this->dateTime(),
            'session' => $this->string(),
        ], $this->tableOptions);

        $name = 'session';
        $this->createIndex($name, $this->tableName, $name);

        $security = Yii::$app->security;
        $params = Yii::$app->params;
        $this->insert($this->tableName, [
                'username' => 'admin',
                'email' => $params['adminEmail'],
                'password_hash' => $security->generatePasswordHash('adminadmin'),
                'salt' => $security->generateRandomString(64),
                'auth_key' => $security->generateRandomString(),
                'access_token' => $security->generateRandomString(40),
                'email_confirmed' => true,
            ]
        );
    }

    /**
     * @inheritdoc
     */
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
