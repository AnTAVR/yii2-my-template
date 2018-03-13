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
                '/login' => '/account/profile/login',
                '/logout' => '/account/profile/logout',
                '/signup' => '/account/profile/signup',
                '/password-reset' => '/account/profile/password-reset',
                '/password-edit' => '/account/profile/password-edit',
                '/verify-email/<user_id:\d+>/<crc:\w+>' => '/account/profile/verify-email',
            ]
        );
        // custom initialization code goes here
    }
}
