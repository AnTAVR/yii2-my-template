<?php

namespace app\modules\uploader;

use app\components\Module as ModuleOld;

/**
 * module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params = require __DIR__ . '/config/params.php';

        // custom initialization code goes here
    }
}
