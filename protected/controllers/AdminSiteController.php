<?php

namespace app\controllers;

use app\modules\rbac\helpers\RBAC;
use yii\web\Controller;

class AdminSiteController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RBAC::ADMIN_PERMISSION],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all StaticPage models.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
