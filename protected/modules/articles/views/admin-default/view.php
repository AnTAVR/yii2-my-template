<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\modules\articles\models\Articles */

$this->title = Yii::t('yii', 'View');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a(Yii::t('yii', 'Update'),
        ['update', 'id' => $model->id],
        [
            'class' => 'btn btn-primary',
        ]) ?>
    <?= Html::a(Yii::t('yii', 'Delete'),
        ['delete', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'content_title',
        'content_short:raw',
        'content_full:raw',
        'published_at:datetime',
        'status_txt',
        'meta_description',
        'meta_keywords',
    ],
]) ?>
