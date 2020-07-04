<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\uploader\models\UploaderImage */
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
