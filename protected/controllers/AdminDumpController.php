<?php

namespace app\controllers;

use app\components\AdminController;

/**
 * AdminDumpController.
 */
class AdminDumpController extends AdminController
{
    /**
     * Lists all StaticPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
