<?php

use app\modules\account\components\AdminPanelMigration;

class m000101_000010_dump_admin_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'dump.openAdminPanel';
}
