<?php

/* @var $this yii\web\View */
/* @var $model app\modules\products\models\Products */

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

$this->title = $model->content_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $model->content_full ?>
