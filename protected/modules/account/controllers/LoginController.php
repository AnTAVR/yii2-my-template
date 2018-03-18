<?php

namespace app\modules\account\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;

class LoginController extends Controller
{
    public function actions()
    {
        $actions = [
            'index' => 'app\modules\account\actions\LoginAction',
        ];

        return ArrayHelper::merge(parent::actions(), $actions);
    }
}
