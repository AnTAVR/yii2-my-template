<?php

/* @var $this \app\components\View */
/* @var $model app\modules\products\models\Products */

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

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['/products']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view products-<?= $model->meta_url ?>">

    <?= $model->content_full ?>

</div>
