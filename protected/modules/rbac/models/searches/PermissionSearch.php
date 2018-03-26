<?php

namespace app\modules\rbac\models\searches;

use Yii;
use yii\rbac\Item;

class PermissionSearch extends AuthItemSearch
{
    public function __construct($config = [])
    {
        parent::__construct($item = null, $config);
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('app', 'Permission name');
        return $labels;
    }

    protected function getType()
    {
        return Item::TYPE_PERMISSION;
    }

}
