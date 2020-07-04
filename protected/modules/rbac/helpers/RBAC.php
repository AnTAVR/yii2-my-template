<?php

namespace app\modules\rbac\helpers;

use Exception;
use Yii;
use yii\rbac\Role;

class RBAC
{
    const ADMIN_PERMISSION = 'admin.openAdminPanel';
    const ADMIN_ROLE = 'admin-role';

    /**
     * @param string $name
     * @param integer|array $userId
     * @param string|null $description
     * @return Role
     * @throws Exception
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

    public static function name2description($name)
    {
        $label = strtolower(trim(str_replace([
            '-',
            '_',
            '.',
        ], ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name))));

        return ucfirst(strtolower($label));
    }
}