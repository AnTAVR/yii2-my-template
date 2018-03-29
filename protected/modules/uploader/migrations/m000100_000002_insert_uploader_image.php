<?php

use app\modules\uploader\models\UploaderImage;
use yii\db\Migration;

class m000100_000002_insert_uploader_image extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = UploaderImage::tableName();
    }

    public function up()
    {
        $this->insert($this->tableName, [
                'file' => 'image.png',
                'comment' => 'image',

                'meta_url' => '15191356815a8c2bc17ad332.97335651.png',
            ]
        );
    }

    public function down()
    {
        $this->delete($this->tableName, ['meta_url' => '15191356815a8c2bc17ad332.97335651.png']);
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
