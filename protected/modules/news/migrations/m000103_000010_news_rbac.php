<?php

use yii\db\Migration;

class m000103_000010_news_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $permission = $authManager->createPermission('news.openAdminPanel');
        $permission->description = 'Open News Admin Panel';
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission('site.openAdminPanel'));

        $authManager->addChild($authManager->getRole('root-role'), $permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('news.openAdminPanel'));
    }
}
