<?php

namespace app\modules\backup\commands;

use yii\console\Controller;

class DefaultController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }
}
