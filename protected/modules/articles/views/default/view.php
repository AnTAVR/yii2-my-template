<?php

use app\modules\articles\models\Articles as Articles;
use yii\web\View;

/* @var $this View */
/* @var $model Articles */

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

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['/articles']];

$this->title = $model->content_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $model->content_full ?>
