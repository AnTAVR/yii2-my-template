<?php

use app\modules\news\models\News;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model News */
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
        'meta_description',
        'meta_keywords',
    ],
]) ?>
