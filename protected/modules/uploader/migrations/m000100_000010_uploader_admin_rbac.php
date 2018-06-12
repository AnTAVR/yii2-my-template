<?php

use app\modules\account\components\AdminPanelMigration;

class m000100_000010_uploader_admin_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'uploader.openAdminPanel';
}
