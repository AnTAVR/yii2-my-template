<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;

class LogoutController extends Controller
{
    public function actions()
    {
        $actions = [
            'index' => 'app\modules\account\actions\LogoutAction',
        ];

        return ArrayHelper::merge(parent::actions(), $actions);
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
