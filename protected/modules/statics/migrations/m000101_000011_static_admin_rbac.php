<?php

use app\modules\account\components\AdminPanelMigration;

class m000101_000011_static_admin_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'statics.openAdminPanel';
}
