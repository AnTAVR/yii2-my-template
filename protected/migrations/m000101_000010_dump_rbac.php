<?php

use yii\db\Migration;

class m000101_000010_dump_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $permission = $authManager->createPermission('dump.openAdminPanel');
        $permission->description = 'Open Dump Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission('site.openAdminPanel'));

        $authManager->addChild($authManager->getRole('root-role'), $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('dump.openAdminPanel'));
    }
}
