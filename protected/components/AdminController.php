<?php

namespace app\components;


use yii\helpers\ArrayHelper;
use yii\web\Controller;

class AdminController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin-role'],
                    ],
                ],
            ],
        ]);
    }
}
