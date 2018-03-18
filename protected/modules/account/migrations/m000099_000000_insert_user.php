<?php

use app\modules\account\models\User;
use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m000099_000001_insert_user extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = User::tableName();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $security = Yii::$app->security;
        $params = Yii::$app->params;
        $this->insert($this->tableName, [
                'username' => 'admin',
                'email' => $params['adminEmail'],
                'password_hash' => $security->generatePasswordHash('adminadmin'),
                'salt' => $security->generateRandomString(64),
                'auth_key' => $security->generateRandomString(),
                'email_confirmed' => true,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->delete($this->tableName, ['id' => 1]);
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
