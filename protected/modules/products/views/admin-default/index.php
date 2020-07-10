<?php

use app\modules\products\models\Category;
use app\modules\products\models\Products;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
$searchModel = null;
$this->title = Yii::t('app', 'Products');
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
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            'attribute' => 'meta_url',
            'value' => function ($data) {
                return $data->url;
            },
        ],
        'content_title',
        'published_at:datetime',
        [
            'attribute' => 'status',
            'value' => function ($data) {
                return Products::$statusNames[$data->status];
            },
        ],
        [
            'attribute' => 'category_id',
            'filter' => Category::find()->select(['content_title', 'id'])->indexBy('id')->column(),
            'value' => 'category.content_title',
        ],
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
