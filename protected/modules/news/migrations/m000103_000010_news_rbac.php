<?php

use app\modules\account\components\AdminPanelMigration;

class m000103_000010_news_rbac extends AdminPanelMigration
{
    const PERMISSION_ADMIN = 'news.openAdminPanel';
}
