<?php

namespace app\modules\rbac\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class Role extends AuthItem
{
    const TYPE = Item::TYPE_ROLE;

    public $permissions = [];

    public function init()
    {
        parent::init();

        if (!$this->isNewRecord) {
            $this->permissions = ArrayHelper::getColumn(static::Permissions($this->item->name), 'name');
        }
    }

    public static function Permissions($roleName)
    {
        $authManager = Yii::$app->authManager;
        return $authManager->getPermissionsByRole($roleName);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $authManager = Yii::$app->authManager;

        $role = $authManager->getRole($this->item->name);
        if (!$insert) {
            $authManager->removeChildren($role);
        }
        if ($this->permissions) {
            foreach ($this->permissions as $permissionName) {
                $permission = $authManager->getPermission($permissionName);
                $authManager->addChild($role, $permission);
            }
        }
    }
}
