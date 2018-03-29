<?php

namespace app\modules\rbac\models;

use yii\rbac\Item;

class Permission extends AuthItem
{
    public $type = Item::TYPE_PERMISSION;
}
