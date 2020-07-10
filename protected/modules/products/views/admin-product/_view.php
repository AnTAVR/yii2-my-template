<?php

use app\modules\products\models\Products;
use yii\helpers\ArrayHelper;
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
        [
            'attribute' => 'status',
            'value' => Products::$statusNames[$model->status],
        ],
        [
            'attribute' => 'category_id',
            'value' => ArrayHelper::getValue($model, 'category.content_title'),
        ],
        'meta_description',
        'meta_keywords',
    ],
]) ?>
