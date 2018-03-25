<?php

namespace app\modules\rbac\models;

use Yii;
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
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('app', 'Role name');
        $labels['permissions'] = Yii::t('app', 'Permissions');
        return $labels;
    }

    /**
     * @inheritdoc
     */
    protected function getType()
    {
        return Item::TYPE_ROLE;
    }

}
