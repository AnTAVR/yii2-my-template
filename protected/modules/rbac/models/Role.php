<?php

namespace app\modules\rbac\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class Role extends AuthItem
{
    public $type = Item::TYPE_ROLE;

    public $permissions = [];

    public function init()
    {
        parent::init();

        if (!$this->isNewRecord) {
            $this->permissions = ArrayHelper::getColumn(static::getPermissions($this->item->name), 'name');
        }
    }

    public static function getPermissions($roleName)
    {
        $authManager = Yii::$app->authManager;
        $items = $authManager->getPermissionsByRole($roleName);
        return $items;
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
