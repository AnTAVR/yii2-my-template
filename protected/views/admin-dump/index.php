<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $activePids array */

$this->title = Yii::t('app', 'Dump');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($activePids)): ?>
    <div class="well">
        <h4><?= Yii::t('app', 'Active processes:') ?></h4>
        <?php foreach ($activePids as $pid => $cmd): ?>
            <b><?= $pid ?></b>: <?= $cmd ?><br>
        <?php endforeach ?>
    </div>
<?php endif ?>

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
        'basename',
        'timestamp:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{download} {restore} {delete}',
            'buttons' => [
                'download' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-download-alt"></span>',
                        [
                            'download',
                            'fileName' => $model['basename'],
                        ],
                        [
                            'title' => Yii::t('app', 'Download'),
                            'data-method' => 'post',
                            'class' => 'btn btn-sm btn-default',
                        ]);
                },
                'restore' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-import"></span>',
                        [
                            'restore',
                            'fileName' => $model['basename'],
                        ],
                        [
                            'title' => Yii::t('app', 'Restore'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app', 'Are you sure?'),
                            'class' => 'btn btn-sm btn-default',
                        ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        [
                            'delete',
                            'fileName' => $model['basename'],
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

