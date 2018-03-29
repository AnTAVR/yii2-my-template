<?php
/* @var $this \yii\web\View */

/* @var $model \app\modules\rbac\models\Role */

use yii\widgets\DetailView;

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'description',
        'ruleName',
        'permissions',
    ],
]) ?>
