<?php

use app\modules\products\models\Products;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Products */
?>
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
        'category_name',
        'meta_description',
        'meta_keywords',
    ],
]) ?>
