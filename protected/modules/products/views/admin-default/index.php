<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create Products'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'productsUrl',
        'content_title',
        'published_at',
        'status_txt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{viewP} {view} {update} {delete}',
            'buttons' => [
                'viewP' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model, $key) {
                    /* @var $model \app\modules\products\models\Products */
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        $model->productsUrl,
                        [
                            'title' => Yii::t('app', 'View site'),
                            'aria-label' => Yii::t('app', 'View site'),
                            'data-pjax' => '0',
                            'target' => '_blank',
                            'style' => 'color: red;',
                        ]);
                },
            ],
        ],
    ],
]); ?>
