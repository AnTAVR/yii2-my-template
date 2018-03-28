<?php

namespace app\modules\rbac;

use app\components\Module as ModuleOld;

class Module extends ModuleOld
{
    public $defaultRoute = 'admin-default';

    public function init()
    {
        parent::init();

        $this->params = require __DIR__ . '/config/params.php';

        // custom initialization code goes here
    }
}
