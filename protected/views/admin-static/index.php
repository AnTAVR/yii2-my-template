<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Static Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Static Page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= /** @noinspection PhpUnhandledExceptionInspection */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'staticUrl',
            'content_title',
            [
                'class' => yii\grid\ActionColumn::class,
                'template' => '{viewP} {view} {update} {delete}',
                'buttons' => [
                    'viewP' => function (/** @noinspection PhpUnusedParameterInspection */
                        $url, $model, $key) {
                        /* @var $model app\models\StaticPage */
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            $model->staticUrl,
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
</div>
