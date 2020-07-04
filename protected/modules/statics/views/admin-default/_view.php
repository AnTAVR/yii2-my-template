<?php

use app\modules\statics\models\StaticPage;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model StaticPage */
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
