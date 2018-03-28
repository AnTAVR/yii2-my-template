<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\models\StaticPage */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['/admin-static']];
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

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'content_title',
        'content_full:raw',
        'meta_description',
        'meta_keywords',
    ],
]) ?>
