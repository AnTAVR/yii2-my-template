<?php

use app\modules\rbac\helpers\RBAC;
use yii\db\Migration;

class m000099_000004_init extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        RBAC::createRole('root-role', 1, 'Root role');

        $permission = $authManager->createPermission('root.openAdminPanel');
        $permission->description = 'Open Admin Panel';
        $authManager->add($permission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission('root.openAdminPanel'));
        $authManager->remove($authManager->getRole('root-role'));
    }
}
