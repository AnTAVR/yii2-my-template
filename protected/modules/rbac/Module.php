<?php

namespace app\modules\rbac;

use app\components\Module as ModuleOld;
use Yii;

class Module extends ModuleOld
{
    public $defaultRoute = 'admin-assignment';

    public function init()
    {
        parent::init();
        $this->params = require __DIR__ . '/config/params.php';

        /** @noinspection HtmlUnknownTag */
        Yii::$app->urlManager->addRules(
            [
                '/rbac/admin-<controller>' => '/rbac/admin-<controller>',
            ]
        );
        // custom initialization code goes here
    }
}
