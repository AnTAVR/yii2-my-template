<?php

use app\modules\uploader\models\UploaderFile;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model UploaderFile */
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
