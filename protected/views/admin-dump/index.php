<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */

$this->title = Yii::t('app', 'Dump');
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
        ]
    ) ?>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create dump'),
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
            'buttons' => [
                'download' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-download-alt"></span>',
                        [
                            'download',
                            'fileName' => $model['file'],
                        ],
                        [
                            'title' => Yii::t('app', 'Download'),
                            'data-method' => 'post',
                            'class' => 'btn btn-sm btn-success',
                        ]);
                },
                'restore' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-import"></span>',
                        [
                            'restore',
                            'fileName' => $model['file'],
                        ],
                        [
                            'title' => Yii::t('app', 'Restore'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app', 'Are you sure?'),
                            'class' => 'btn btn-sm btn-default',
                        ]);
                },
                'delete' => function (/** @noinspection PhpUnusedParameterInspection */
                    $url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        [
                            'delete',
                            'fileName' => $model['file'],
                        ],
                        [
                            'title' => Yii::t('app', 'Delete'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app', 'Are you sure?'),
                            'class' => 'btn btn-sm btn-danger',
                        ]);
                },
            ],
        ],
    ],
]) ?>

