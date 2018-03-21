<?php

namespace app\modules\backup;

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
//        $app = Yii::$app;

        // add console command
//        if ($app instanceof Application) {
//            if (!isset($app->controllerMap['dump'])) {
//                $app->controllerMap['dump'] = 'app\modules\backup\commands\DumpController';
//            }
//        }

        // custom initialization code goes here
    }
}
