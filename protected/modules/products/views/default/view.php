<?php

use app\modules\products\models\Category;
use app\modules\products\models\Products;
use yii\web\View;

/* @var $category Category */
/* @var $model Products */
/* @var $this View */

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

$this->params['breadcrumbs'][] = ['label' => $category->content_title, 'url' => $category->arrUrl];

$this->title = $model->content_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $model->content_full ?>
