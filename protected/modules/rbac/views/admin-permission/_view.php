<?php

use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\modules\rbac\models\Permission */
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
