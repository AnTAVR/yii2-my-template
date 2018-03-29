<?php

namespace app\modules\rbac\models\searches;

use yii\rbac\Item;

class RoleSearch extends AuthItemSearch
{

    public function __construct($config = [])
    {
        parent::__construct($item = null, $config);
    }

    /**
     * @inheritdoc
     */
    protected function getType()
    {
        return Item::TYPE_ROLE;
    }

}
