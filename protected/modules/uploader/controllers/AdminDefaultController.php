<?php

namespace app\modules\uploader\controllers;

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
