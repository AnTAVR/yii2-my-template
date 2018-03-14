<?php

namespace app\modules\products;

use app\components\Module as ModuleOld;
use Yii;

/**
 * products module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\products\controllers';
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
