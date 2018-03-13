<?php

namespace app\modules\user;

use app\components\Module as ModuleOld;

/**
 * user module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\user\controllers';
    public $defaultRoute = 'profile';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        /** @noinspection HtmlUnknownTag */
        \Yii::$app->urlManager->addRules(
            [
                '/user/admin-<controller>' => '/user/admin-<controller>',
            ]
        );

        // custom initialization code goes here
    }
}
