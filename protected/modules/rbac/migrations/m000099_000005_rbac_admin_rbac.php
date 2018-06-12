<?php

use app\modules\account\components\AdminPanelMigration;

class m000099_000005_rbac_admin_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'rbac.openAdminPanel';
}
