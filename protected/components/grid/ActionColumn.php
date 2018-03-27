<?php

namespace app\components\grid;

use Yii;
use yii\grid\ActionColumn as OldActionColumn;

class ActionColumn extends OldActionColumn
{
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
