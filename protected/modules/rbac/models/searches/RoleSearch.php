<?php

namespace app\modules\rbac\models\searches;

use app\modules\rbac\models\Role;

class RoleSearch extends Role
{
    public function __construct($config = [])
    {
        parent::__construct($item = null, $config);
    }

    public function rules()
    {
        return [
            ['name', 'safe'],
        ];
    }
}
