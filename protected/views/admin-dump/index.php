<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\base\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */

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
            'data-confirm' => Yii::t('app', 'Are you sure?'),
        ]) ?>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create Dump'),
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
        'file',
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{download} {restore} {delete}',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
            'buttons' => [
                'download' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    $icon = 'download-alt';
                    $title = Yii::t('app', 'Download');
                    if ($icon) {
                        $icon = Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-$icon",
                        ]);
                    }
                    $options = [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'data-method' => 'post',
                    ];
                    return Html::a($icon, $url, $options);
                },
                'restore' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    $icon = 'import';
                    $title = Yii::t('app', 'Restore');
                    if ($icon) {
                        $icon = Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-$icon",
                        ]);
                    }
                    $options = [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('app', 'Are you sure?'),
                    ];
                    return Html::a($icon, $url, $options);
                },
                'delete' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    $icon = 'trash';
                    $title = Yii::t('app', 'Delete');
                    if ($icon) {
                        $icon = Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-$icon",
                        ]);
                    }
                    $options = [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('app', 'Are you sure?'),
                    ];
                    return Html::a($icon, $url, $options);
                },
            ],
        ],
    ],
]) ?>

