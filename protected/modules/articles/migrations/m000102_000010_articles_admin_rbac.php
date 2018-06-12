<?php

use app\modules\account\components\AdminPanelMigration;

class m000102_000010_articles_admin_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'articles.openAdminPanel';
}
