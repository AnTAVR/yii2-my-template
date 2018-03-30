<?php

use app\modules\rbac\helpers\RBAC;
use yii\db\Migration;

class m000099_000004_init extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $rootRole = RBAC::createRole('root-role', 1, 'Root role');

        $openAdminPanelPermission = $authManager->createPermission('root.openAdminPanel');
        $openAdminPanelPermission->description = 'Open Admin Panel';
        $authManager->add($openAdminPanelPermission);
        $authManager->addChild($rootRole, $openAdminPanelPermission);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->removeAll();
    }
}
