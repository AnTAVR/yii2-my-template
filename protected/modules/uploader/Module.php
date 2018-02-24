<?php

namespace app\modules\uploader;

use app\components\Module as ModuleOld;

/**
 * uploader module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\uploader\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
