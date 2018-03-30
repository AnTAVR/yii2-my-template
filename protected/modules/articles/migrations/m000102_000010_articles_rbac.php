<?php

use yii\db\Migration;

class m000102_000010_articles_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $permission = $authManager->createPermission('articles.openAdminPanel');
        $permission->description = 'Open Articles Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission('root.openAdminPanel'));

        $authManager->addChild($authManager->getRole('root-role'), $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('articles.openAdminPanel'));
    }
}
