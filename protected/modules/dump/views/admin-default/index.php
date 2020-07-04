<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = Yii::t('app', 'Dump DB');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>' . Yii::t('app', 'Delete all'),
        ['delete-all'],
        [
            'class' => 'btn btn-danger',
            'data-method' => 'post',
            'data-confirm' => Yii::t('app', 'Delete all?'),
        ]) ?>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create'),
        ['create'],
        [
            'class' => 'btn btn-success',
            'data-method' => 'post',
        ]) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'file',
            'label' => Yii::t('app', 'File'),
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'created_at',
            'format' => 'datetime',
            'label' => Yii::t('app', 'Created At'),
        ],
        [
            'class' => 'app\components\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'template' => '{download} {restore} {delete}',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]) ?>

