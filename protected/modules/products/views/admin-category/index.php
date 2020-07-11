<?php

use app\modules\products\models\searches\CategorySearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel CategorySearch */

$this->title = Yii::t('app', 'Category');
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
