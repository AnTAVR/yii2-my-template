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
        'url',
        'content_title',
        'published_at:datetime',
        'status_txt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{viewP} {view} {update} {delete}',
            'buttons' => [
                'viewP' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model, $key) {
                    $icon = 'eye-open';
                    $title = Yii::t('app', 'View site');
                    if ($icon) {
                        $icon = Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-$icon",
                        ]);
                    }
                    $options = [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'class' => 'btn btn-sm btn-success',
                        'target' => '_blank',
                    ];
                    /* @var $model \app\modules\news\models\News */
                    return Html::a($icon, $model->url, $options);
                },
            ],
        ],
    ],
]); ?>
