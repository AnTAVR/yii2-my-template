<?php

namespace app\modules\account;

use app\components\Module as ModuleOld;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Application;
use yii\web\User;

class Module extends ModuleOld implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
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
                '/signup' => '/account/signup',
                '/account/verify-email/<token:\w+>' => '/account/verify-email',
                '/recovery' => '/account/recovery',
                '/recovery/new/<token:\w+>' => '/account/recovery/new',
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
