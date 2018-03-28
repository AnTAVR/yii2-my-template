<?php

namespace app\modules\uploader;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    public $defaultRoute = 'admin-default';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->modulesName = Yii::t('app', 'Uploader');
        $this->params = require __DIR__ . '/config/params.php';

        // custom initialization code goes here
    }
}
