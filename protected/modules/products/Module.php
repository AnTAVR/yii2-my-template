<?php

namespace app\modules\products;

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
                '/products/<meta_url:[\w\-]+>/page<page:\d+>' => '/products/default/index',
                '/products/page<page:\d+>' => '/products/default/index',
                '/products/view/<meta_url:[\w\-]+>' => '/products/default/view',
            ]
        );

        // custom initialization code goes here
    }
}
