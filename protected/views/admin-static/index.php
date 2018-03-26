<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Static Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create Static Page'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= /** @noinspection PhpUnhandledExceptionInspection */
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'url',
        'content_title',
        [
            'class' => ActionColumn::class,
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
                    /* @var $model \app\models\StaticPage */
                    return Html::a($icon, $model->url, $options);
                },
            ],
        ],
    ],
]); ?>
