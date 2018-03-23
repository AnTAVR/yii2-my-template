<?php

namespace app\modules\products;

use app\components\Module as ModuleOld;
use Yii;

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

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/products/admin-<controller>' => '/products/admin-<controller>',
                '/products/page-<page\d+>' => '/products/default/index',
                '/products/<meta_url>' => '/products/default/view',
            ]
        );
        // custom initialization code goes here
    }
}
