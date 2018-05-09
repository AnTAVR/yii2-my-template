<?php

namespace app\components\grid;

use Yii;
use yii\grid\ActionColumn as OldActionColumn;
use yii\helpers\Url;

class ActionColumn extends OldActionColumn
{
    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        }

        if ($action === 'viewOnSite') {
            /** @noinspection PhpUndefinedFieldInspection */
            return $model->url;
        }

        $params = is_array($key) ? $key : ['id' => (string)$key];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

        return Url::toRoute($params);
    }

    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        $this->initDefaultButton('viewOnSite', 'link', [
            'title' => Yii::t('app', 'View on site'),
            'target' => '_blank',
        ]);
        $this->initDefaultButton('restore', 'import', [
            'title' => Yii::t('app', 'Restore'),
            'data-confirm' => Yii::t('app', 'Restore?'),
            'data-method' => 'post',
        ]);
        $this->initDefaultButton('download', 'download-alt', [
            'title' => Yii::t('app', 'Download'),
            'data-method' => 'post',
        ]);
    }
}
