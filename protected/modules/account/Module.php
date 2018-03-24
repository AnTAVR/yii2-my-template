<?php

namespace app\modules\account;

use app\components\Module as ModuleOld;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Application;
use yii\web\User;

/**
 * module definition class
 */
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

        $i18n = Yii::$app->i18n;
        if (!isset($i18n->translations['account'])) {
            $i18n->translations['account'] = [
                'class' => 'yii\i18n\PhpMessageSource',
//                'sourceLanguage' => 'en-US',
                'basePath' => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
            ];
        }

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/account/admin-<controller>' => '/account/admin-<controller>',
                '/signup' => '/account/signup',
                '/signup/verify-email/<token:\w+>' => '/account/signup/verify-email',
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
