<?php

namespace app\modules\profile;

use app\components\Module as ModuleOld;

/**
 * profile module definition class
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
                '/profile/admin-<controller>' => '/profile/admin-<controller>',
                '/profile/<controller:[\w-]+>' => '/profile/profile/<controller>',
            ]
        );

        // custom initialization code goes here
    }
}
