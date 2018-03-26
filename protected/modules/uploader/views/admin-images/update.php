<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\modules\uploader\models\UploaderImage */

$this->title = Yii::t('app', 'Update Image: {name}', ['name' => $model->file]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="image-form">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'file',
            'thumbnailUrl:image:',
            'thumbnailUrl:ntext',
            'url:ntext',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'POST',
                ],
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
