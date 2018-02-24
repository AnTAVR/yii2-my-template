<?php

namespace app\components;


use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
