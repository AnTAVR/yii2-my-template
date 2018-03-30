<?php

namespace app\modules\rbac\helpers;

use Yii;

class RBAC
{
    /**
     * @param string $name
     * @param integer|array $userId
     * @param string|null $description
     * @return \yii\rbac\Role
     * @throws \Exception
     */
    static public function createRole($name, $userId, $description = null)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->createRole($name);
        $role->description = $description;
        $auth->add($role);

        if (!is_array($userId)) {
            $userId = [$userId];
        }

        foreach ($userId as $id) {
            $auth->assign($role, $id);
        }

        return $role;
    }
}