<?php

namespace app\modules\articles;

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
                '/articles/page<page:\d+>' => '/articles/default/index',
                '/articles/view/<meta_url:[\w\-]+>' => '/articles/default/view',
            ]
        );

        // custom initialization code goes here
    }
}
