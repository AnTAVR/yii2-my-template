<?php

use yii\db\Migration;

class m000100_000010_uploader_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $permission = $authManager->createPermission('uploader.openAdminPanel');
        $permission->description = 'Open Uploader Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission('root.openAdminPanel'));

        $authManager->addChild($authManager->getRole('root-role'), $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('uploader.openAdminPanel'));
    }
}
