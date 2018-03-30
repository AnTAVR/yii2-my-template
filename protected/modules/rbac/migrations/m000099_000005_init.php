<?php

use yii\db\Migration;

class m000099_000005_init extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $rootRole = $authManager->getRole('root-role');

        $permission = $authManager->createPermission('rbac.openAdminPanel');
        $permission->description = 'Open RBAC Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($rootRole, $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('rbac.openAdminPanel'));
    }
}
