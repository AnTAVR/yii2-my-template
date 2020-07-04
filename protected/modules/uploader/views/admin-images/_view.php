<?php

use app\modules\uploader\models\UploaderImage;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model UploaderImage */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'thumbnailUrl',
        'thumbnailUrl:image:',
        'url:image:',
        'file',
        'comment:ntext',
    ],
]) ?>
