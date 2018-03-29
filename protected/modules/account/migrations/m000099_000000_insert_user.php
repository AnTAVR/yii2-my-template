<?php

use app\modules\account\models\User;
use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m000099_000000_insert_user extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = User::tableName();
    }

    public function up()
    {
        $params = Yii::$app->params;
        $model = new User([
            'username' => 'admin',
            'email' => $params['adminEmail'],
            'email_confirmed' => true,
        ]);
        $model->generatePassword('adminadmin');
        $model->save(false);


        $model = new User([
            'username' => 'tests',
            'email' => 'tests@tests.tests',
            'email_confirmed' => true,
        ]);
        $model->generatePassword('teststests');
        $model->save(false);
    }

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
