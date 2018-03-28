<?php

namespace app\modules\news;

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
                '/news/page/<page\d+>' => '/news/default/index',
                '/news/view/<meta_url>' => '/news/default/view',
            ]
        );
        // custom initialization code goes here
    }
}
