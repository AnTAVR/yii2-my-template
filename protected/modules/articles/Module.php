<?php

namespace app\modules\articles;

use app\components\Module as ModuleOld;

/**
 * articles module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\articles\controllers';
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
                '/articles/admin-<controller>' => '/articles/admin-<controller>',
                '/articles/page-<page\d+>' => '/articles/default/index',
                '/articles/<meta_url>' => '/articles/default/view',
            ]
        );
        // custom initialization code goes here
    }
}
