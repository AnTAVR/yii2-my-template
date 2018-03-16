<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Articles'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= /** @noinspection PhpUnusedParameterInspection */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'articlesUrl',
            'content_title',
            'published_at',
            'status_txt',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewP} {view} {update} {delete}',
                'buttons' => [
                    'viewP' => function (/** @noinspection PhpUnusedParameterInspection */
                        $url, $model, $key) {
                        /* @var $model app\modules\articles\models\Articles */
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            $model->articlesUrl,
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
