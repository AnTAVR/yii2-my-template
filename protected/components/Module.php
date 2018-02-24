<?php

namespace app\components;

use Yii;
use yii\base\Module as ModuleOld;
use yii\console\Application;

/**
 * articles module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (Yii::$app instanceof Application) {
            $this->controllerNamespace = str_replace('\controllers', '\commands', $this->controllerNamespace);
        }

        // custom initialization code goes here
    }
}
