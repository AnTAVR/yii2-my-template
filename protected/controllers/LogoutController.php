<?php

namespace app\controllers;

use yii\web\Controller;

class LogoutController extends Controller
{
    public function actions()
    {
        return [
            'index' => 'app\modules\account\actions\LogoutAction',
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }
}
