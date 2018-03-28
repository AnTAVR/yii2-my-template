<?php

namespace app\modules\rbac;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    public $defaultRoute = 'admin-default';

    public function init()
    {
        parent::init();

        $this->modulesName = Yii::t('app', 'RBAC');
        $this->params = require __DIR__ . '/config/params.php';

        // custom initialization code goes here
    }
}
