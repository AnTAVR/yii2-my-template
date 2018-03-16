<?php

/* @var $this \app\components\View */
/* @var $model \app\models\StaticPage */
/* @var $breadcrumbs boolean */

$this->title = $model->content_title;
if (!empty($model->meta_description))
{
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $model->meta_description]);
}

if (!empty($model->meta_keywords)) {
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $model->meta_keywords]);
}
if (!isset($breadcrumbs)) {
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<?= $model->content_full ?>
