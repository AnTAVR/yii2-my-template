<?php

namespace app\controllers;

use app\components\AdminController;

/**
 * AdminStaticPageController implements the CRUD actions for StaticPage model.
 */
class AdminSiteController extends AdminController
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
