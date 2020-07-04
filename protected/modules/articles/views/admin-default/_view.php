<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\articles\models\Articles */

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
