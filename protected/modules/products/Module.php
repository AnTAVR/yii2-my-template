<?php

namespace app\modules\products;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->params = require __DIR__ . '/config/params.php';

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/products/page/<page\d+>' => '/products/default/index',
                '/products/view/<meta_url>' => '/products/default/view',
            ]
        );

        // custom initialization code goes here
    }
}
