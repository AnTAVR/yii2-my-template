<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\statics\models\StaticPage */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['/statics/admin-default']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

$this->title = Yii::t('yii', 'View');
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a(Yii::t('yii', 'Update'),
        ['update', 'id' => $model->id],
        [
            'class' => 'btn btn-primary',
        ]) ?>
    <?= Html::a(Yii::t('yii', 'Delete'),
        ['delete', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
</p>
<?= $this->render('_view', [
    'model' => $model,
]) ?>
