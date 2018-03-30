<?php

use yii\db\Migration;

class m000104_000010_products_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $permission = $authManager->createPermission('products.openAdminPanel');
        $permission->description = 'Open Products Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission('site.openAdminPanel'));

        $authManager->addChild($authManager->getRole('root-role'), $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('products.openAdminPanel'));
    }
}
