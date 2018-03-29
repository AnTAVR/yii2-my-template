<?php

namespace app\modules\rbac\models;

use Yii;
use yii\rbac\Item;

class Role extends AuthItem
{
    public $type = Item::TYPE_ROLE;

    public $permissions = [];

    public function init()
    {
        parent::init();
        if (!$this->isNewRecord) {
            $permissions = [];
            foreach (static::getPermissions($this->item->name) as $permission) {
                $permissions[] = $permission->name;
            }
            $this->permissions = $permissions;
        }
    }

    public static function find($name)
    {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getRole($name);
        return new self($item);
    }

    public static function getPermissions($name)
    {
        $authManager = Yii::$app->authManager;
        return $authManager->getPermissionsByRole($name);
    }

    public function afterSave(/** @noinspection PhpUnusedParameterInspection */
        $insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $authManager = Yii::$app->authManager;

        $role = $authManager->getRole($this->item->name);
        if (!$insert) {
            $authManager->removeChildren($role);
        }
        if ($this->permissions != null && is_array($this->permissions)) {
            foreach ($this->permissions as $permissionName) {
                $permission = $authManager->getPermission($permissionName);
                $authManager->addChild($role, $permission);
            }
        }
    }
}
