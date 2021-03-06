<?php

namespace app\modules\news;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    public function init()
    {
        parent::init();

        $this->params = require __DIR__ . '/config/params.php';

        Yii::$app->urlManager->addRules(
            [
                '/news/page<page:\d+>' => '/news/default/index',
                '/news/view/<meta_url:[\w\-]+>' => '/news/default/view',
            ]
        );

        // custom initialization code goes here
    }
}
