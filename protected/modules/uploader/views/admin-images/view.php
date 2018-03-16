<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \app\components\View */
/* @var $model app\modules\uploader\models\UploaderImage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_url',
            'imageUrl',
            'thumbnailUrl',
            'thumbnailUrl:image:',
            'imageUrl:image:',
            'file',
            'comment:ntext',
        ],
    ]) ?>

</div>
