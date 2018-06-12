<?php

use app\modules\account\components\AdminPanelMigration;

class m000104_000010_products_rbac_admin extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'products.openAdminPanel';
}
