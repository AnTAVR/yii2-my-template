<?php

namespace app\components;

use Yii;
use yii\base\Module as ModuleOld;
use yii\console\Application;

class Module extends ModuleOld
{
    const ADMIN_START_CONTROLLER = 'admin';

    public $modulesName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (Yii::$app instanceof Application) {
            $this->controllerNamespace = str_replace('\\controllers', '\\commands', $this->controllerNamespace);
        }

//        $i18n = Yii::$app->i18n;
//        if (!isset($i18n->translations[$this->uniqueId])) {
//            $i18n->translations[$this->uniqueId] = [
//                'class' => 'yii\i18n\PhpMessageSource',
////                'sourceLanguage' => 'en-US',
//                'basePath' => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
//            ];
//        }

        // custom initialization code goes here
    }
}
