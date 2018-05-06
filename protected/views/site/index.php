<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\StaticPage */

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

$this->title = $model->content_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $model->content_full ?>
