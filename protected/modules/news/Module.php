<?php

namespace app\modules\news;

use app\components\Module as ModuleOld;

/**
 * news module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\news\controllers';
    public $params = [
        'pageSize' => 10,
        'adminPageSize' => 10,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        /** @noinspection HtmlUnknownTag */
        \Yii::$app->urlManager->addRules(
            [
                '/news/admin-<controller>' => '/news/admin-<controller>',
                '/news/page-<page\d+>' => '/news/default/index',
                '/news/<meta_url>' => '/news/default/view',
            ]
        );
        // custom initialization code goes here
    }
}
