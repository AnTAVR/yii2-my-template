<?php

use app\modules\account\models\User;
use yii\db\Migration;

class m000099_000000_insert_tests_user extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = User::tableName();
    }

    public function up()
    {
        $security = Yii::$app->security;

        $this->insert($this->tableName, [
            'username' => 'tests',
            'created_at' => time(),
            'email' => 'tests@tests.tests',
            'email_confirmed' => true,
            'status' => User::STATUS_ACTIVE,
            'auth_key' => $security->generateRandomString(),
            'salt' => $security->generateRandomString(64),
            'password_hash' => Yii::$app->security->generatePasswordHash('adminadmin')
        ]);
    }

    public function down()
    {
        $this->delete($this->tableName, ['username' => 'tests']);
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
