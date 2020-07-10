<?php

use app\modules\products\models\Category;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Category */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'content_title',
        'content_full:raw',
        'published_at:datetime',
        'meta_description',
        'meta_keywords',
    ],
]) ?>
