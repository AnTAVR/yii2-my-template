<?php

namespace app\modules\rbac\controllers;

use app\components\AdminController;

class AdminDefaultController extends AdminController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
