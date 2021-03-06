<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

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
        'id',
        'url',
        'content_title',
        'published_at:datetime',
        'status_txt',
        [
            'class' => 'app\components\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'template' => '{viewOnSite} {view} {update} {delete}',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]); ?>
