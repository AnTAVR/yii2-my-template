<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\uploader\models\UploaderFile */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'meta_url',
        'url',
        'file',
        'comment:ntext',
    ],
]) ?>
