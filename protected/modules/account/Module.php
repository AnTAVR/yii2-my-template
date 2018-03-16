<?php

namespace app\modules\account;

use app\components\Module as ModuleOld;
use Yii;

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
        $this->params = require __DIR__ . '/config/params.php';

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/account/admin-<controller>' => '/account/admin-<controller>',
                '/login' => '/account/login',
                '/logout' => '/account/logout',
                '/signup' => '/account/signup',
                '/signup/verify-email/<user_id:\d+>/<token:\w+>' => '/account/signup/verify-email',
                '/password' => '/account/password',
                '/password/new/<user_id:\d+>/<token:\w+>' => '/account/password/new',
            ]
        );
        // custom initialization code goes here
    }
}
