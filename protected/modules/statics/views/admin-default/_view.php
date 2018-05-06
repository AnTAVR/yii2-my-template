<?php

use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\modules\statics\models\StaticPage */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'content_title',
        'content_full:raw',
        'meta_description',
        'meta_keywords',
    ],
]) ?>
