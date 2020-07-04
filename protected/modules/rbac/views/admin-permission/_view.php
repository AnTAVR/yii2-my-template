<?php

use app\modules\rbac\models\Permission;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Permission */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'description',
        'ruleName',
        'createdAt:datetime',
        'updatedAt:datetime',
    ],
]) ?>
