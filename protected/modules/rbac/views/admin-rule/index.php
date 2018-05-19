<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rules Manager');
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
        'createdAt:timestamp',
        'updatedAt:timestamp',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]) ?>
