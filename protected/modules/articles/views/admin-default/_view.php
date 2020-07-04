<?php

use app\modules\articles\models\Articles;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Articles */

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
