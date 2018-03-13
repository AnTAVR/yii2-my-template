<?php

namespace app\modules\account;

use app\components\Module as ModuleOld;

/**
 * account module definition class
 */
class Module extends ModuleOld
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\account\controllers';
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
                '/account/admin-<controller>' => '/account/admin-<controller>',
                '/account/login' => '/account/profile/login',
                '/account/logout' => '/account/profile/logout',
                '/account/signup' => '/account/profile/signup',
            ]
        );
        // custom initialization code goes here
    }
}
