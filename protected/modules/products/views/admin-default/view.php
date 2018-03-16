<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \app\components\View */
/* @var $model \app\modules\products\models\Products */

$this->title = $model->content_title;
if (!empty($model->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $model->meta_description]);
}

if (!empty($model->meta_keywords)) {
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $model->meta_keywords]);
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view products-<?= $model->meta_url ?>">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_url',
            'productsUrl',
            'content_title',
            'content_short:raw',
            'content_full:raw',
            'published_at',
            'status_txt',
            'meta_description',
            'meta_keywords',
        ],
    ]) ?>

</div>
