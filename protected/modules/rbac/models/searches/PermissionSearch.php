<?php

namespace app\modules\rbac\models\searches;

use yii\rbac\Item;

class PermissionSearch extends AuthItemSearch
{
    public function __construct($config = [])
    {
        parent::__construct($item = null, $config);
    }

    protected function getType()
    {
        return Item::TYPE_PERMISSION;
    }

}
