<?php

use app\modules\rbac\models\Role;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Role */

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
