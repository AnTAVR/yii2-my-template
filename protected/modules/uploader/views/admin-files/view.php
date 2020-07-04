<?php

use app\modules\uploader\models\UploaderFile;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model UploaderFile */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a(Yii::t('yii', 'Update'),
        ['update', 'id' => $model->id],
        [
            'class' => 'btn btn-primary',
        ]) ?>
    <?= Html::a(Yii::t('yii', 'Delete'),
        ['delete', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
</p>
<?= $this->render('_view', [
    'model' => $model,
]) ?>
