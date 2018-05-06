<?php

namespace app\modules\statics;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    public function init()
    {
        parent::init();

        $this->params = require __DIR__ . '/config/params.php';

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/statics/<meta_url:\w+>' => '/statics/default/index',
            ]
        );

        // custom initialization code goes here
    }
}
