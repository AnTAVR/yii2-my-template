<?php

namespace app\components;

use Yii;
use yii\base\Module as ModuleOld;
use yii\console\Application;

class Module extends ModuleOld
{
    const ADMIN_START_CONTROLLER = 'admin';

    public $modulesName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (Yii::$app instanceof Application) {
            $this->controllerNamespace = str_replace('\\controllers', '\\commands', $this->controllerNamespace);
        }

//        $i18n = Yii::$app->i18n;
//        if (!isset($i18n->translations[$this->uniqueId])) {
//            $i18n->translations[$this->uniqueId] = [
//                'class' => 'yii\i18n\PhpMessageSource',
////                'sourceLanguage' => 'en-US',
//                'basePath' => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
//            ];
//        }

        // custom initialization code goes here
    }

    public function beforeAction($action)
    {
        if ($this->modulesName) {
            $is_ok = true;
            $controller = $action->controller;
            if (in_array($controller->id, [$this->defaultRoute, static::ADMIN_START_CONTROLLER . '-default'])) {
                if ($action->id === $controller->defaultAction) {
                    $is_ok = false;
                }
            }
            if ($is_ok) {
                $is_admin_controller = substr($controller->id, 0, strlen(static::ADMIN_START_CONTROLLER)) === static::ADMIN_START_CONTROLLER;
                $url = [$is_admin_controller ? "/$this->uniqueId/$controller->id" : "/$this->uniqueId"];

                $breadcrumb = [
                    'label' => $this->modulesName,
                    'url' => $url,
                ];

                $controller->view->params['breadcrumbs'][] = $breadcrumb;
            }
        }

        return parent::beforeAction($action);
    }
}
