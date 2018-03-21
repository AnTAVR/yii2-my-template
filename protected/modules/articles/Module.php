<?php

namespace app\modules\articles;

use app\components\Module as ModuleOld;
use Yii;

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
        $this->params = require __DIR__ . '/config/params.php';

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/articles/admin-<controller>' => '/articles/admin-<controller>',
                '/articles/page-<page\d+>' => '/articles/default/index',
                '/articles/<meta_url>' => '/articles/default/view',
            ]
        );
        // custom initialization code goes here
    }
}
