<?php

namespace app\modules\rbac\models;

use Yii;
use yii\rbac\Item;

/**
 * Description of Permission
 */
class Permission extends AuthItem
{
    protected function getType()
    {
        return Item::TYPE_PERMISSION;
    }

    public static function find($name)
    {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getPermission($name);
        return new self($item);
    }
}
