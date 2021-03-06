<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider|yii\data\ArrayDataProvider */

$this->title = Yii::t('app', 'Permissions Manager');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('../menu.php') ?>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create'),
        ['create'],
        [
            'class' => 'btn btn-success',
        ]) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'description',
        'ruleName',
        'createdAt:datetime',
        'updatedAt:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]) ?>
