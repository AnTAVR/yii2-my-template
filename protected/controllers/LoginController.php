<?php

namespace app\controllers;

use yii\web\Controller;

class LoginController extends Controller
{
    public function actions()
    {
        return [
            'index' => 'app\modules\account\actions\LoginAction',
        ];
    }
}
