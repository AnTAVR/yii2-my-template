<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \app\modules\uploader\models\UploaderFile */

$this->title = Yii::t('app', 'Update File: {name}', ['name' => $model->file]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="file-form">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'file',
            'url:ntext',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
                [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
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
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
