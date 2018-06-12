<?php

namespace app\modules\account\components;

use app\modules\rbac\helpers\RBAC;
use Yii;
use yii\db\Migration;

class AdminPanelMigration extends Migration
{
    const PERMISSION_ADMIN = null;

    public function up()
    {
        $authManager = Yii::$app->authManager;

        $name = $this::PERMISSION_ADMIN;
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $permission = $authManager->createPermission($name);
        $permission->description = RBAC::name2description($name);
        $authManager->add($permission);

        $authManager->addChild($permission, $authManager->getPermission(RBAC::ADMIN_PERMISSION));

        $authManager->addChild($authManager->getRole(RBAC::ADMIN_ROLE), $permission);
        $this->endCommand($time);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission($this::PERMISSION_ADMIN));
    }
}
