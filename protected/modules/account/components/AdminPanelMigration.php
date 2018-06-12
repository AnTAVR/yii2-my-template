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

        $time = $this->beginCommand("RBAC::createPermission '{$this::PERMISSION_ADMIN}'");
        $permission = $authManager->createPermission($this::PERMISSION_ADMIN);
        $permission->description = RBAC::name2description($this::PERMISSION_ADMIN);
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
