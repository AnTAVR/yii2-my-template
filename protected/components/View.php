<?php

namespace app\components;

use Yii;
use yii\web\View as OldView;

class View extends OldView
{
    public $uniqueId;
    public $divClass;

    public function beforeRender($viewFile, $params)
    {
        $controller = Yii::$app->controller;
        $this->uniqueId = str_replace('/', '-', $controller->action->uniqueId);
        $this->divClass = str_replace('/', '-', $controller->uniqueId);
        return parent::beforeRender($viewFile, $params);
    }
}