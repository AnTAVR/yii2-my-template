<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'newsUrl',
        'content_title',
        'published_at',
        'status_txt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{viewP} {view} {update} {delete}',
            'buttons' => [
                'viewP' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model, $key) {
                    /* @var $model \app\modules\news\models\News */
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        $model->newsUrl,
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
