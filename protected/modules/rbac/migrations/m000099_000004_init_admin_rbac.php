<?php

use app\modules\rbac\helpers\RBAC;
use yii\db\Migration;

class m000099_000004_init_admin_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $name = RBAC::ADMIN_ROLE;
        $time = $this->beginCommand("RBAC::createRole '{$name}'");
        RBAC::createRole($name, 1, RBAC::name2description($name));
        $this->endCommand($time);

        $name = RBAC::ADMIN_PERMISSION;
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $permission = $authManager->createPermission($name);
        $permission->description = RBAC::name2description($name);
        $authManager->add($permission);
        $this->endCommand($time);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getPermission(RBAC::ADMIN_PERMISSION));
        $authManager->remove($authManager->getRole(RBAC::ADMIN_ROLE));
    }
}
