<?php

namespace app\controllers;

use app\components\AdminController;

class AdminSiteController extends AdminController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['root.openAdminPanel'],
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
