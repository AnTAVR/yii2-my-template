<?php

namespace app\components\grid;

use Yii;
use yii\grid\ActionColumn as OldActionColumn;
use yii\helpers\Url;

class ActionColumn extends OldActionColumn
{
    public function init()
    {
        parent::init();
        $this->urlCreator = function (/** @noinspection PhpUnusedParameterInspection */
            $action, $model, $key, $index, $this_is) {
            if ($action === 'viewP') {
                return $model->url;
            }
            $params = is_array($key) ? $key : ['id' => (string)$key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        };
    }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('viewP', 'eye-open', [
            'class' => 'btn btn-sm btn-success',
            'title' => Yii::t('app', 'View on site'),
            'target' => '_blank',
        ]);
        $this->initDefaultButton('view', 'eye-open', [
            'class' => 'btn btn-sm btn-default',
        ]);
        $this->initDefaultButton('update', 'pencil', [
            'class' => 'btn btn-sm btn-default',
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-sm btn-danger',
        ]);
    }
}
