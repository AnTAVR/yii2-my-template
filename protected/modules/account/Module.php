<?php

namespace app\modules\account;

use app\components\Module as ModuleOld;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Application;
use yii\web\User;

/**
 * account module definition class
 */
class Module extends ModuleOld implements BootstrapInterface
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
                '/signup/verify-email/<token:\w+>' => '/account/signup/verify-email',
                '/password' => '/account/password',
                '/password/new/<token:\w+>' => '/account/password/new',
            ]
        );
        // custom initialization code goes here
    }


    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $app->user->on(User::EVENT_AFTER_LOGIN, ['app\modules\account\events\AfterLoginEvent', 'run']);
            $app->user->on(User::EVENT_BEFORE_LOGOUT, ['app\modules\account\events\BeforeLogoutEvent', 'run']);
            $app->on(Application::EVENT_BEFORE_REQUEST, ['app\modules\account\events\BeforeRequestEvent', 'run']);
        }
    }
}
