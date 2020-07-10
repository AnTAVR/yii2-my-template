<?php

use app\modules\products\models\Category;
use app\modules\products\models\Products;
use app\widgets\CKEditor\CKEditor;
use app\widgets\DateTimePicker\DateTimePicker;
use app\widgets\UrlTranslit\UrlTranslit;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Products */


?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'meta_url')->widget(UrlTranslit::class, [
    'fromField' => 'content_title',
    'options' => ['maxlength' => true]
]) ?>

<div class="row">
    <?= $form->field($model, 'published', ['options' => ['class' => 'col-xs-4']])->widget(DateTimePicker::class, [
        'clientOptions' => [
            'format' => 'yyyy-mm-dd hh:ii:ss',
            'todayBtn' => true,
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'status', ['options' => ['class' => 'col-xs-4']])->dropDownList(Products::$statusNames) ?>

    <?= $form->field($model, 'category_id', ['options' => ['class' => 'col-xs-4']])->dropDownList(Category::find()->select(['content_title', 'id'])->indexBy('id')->column()) ?>

</div>

<?= $form->field($model, 'content_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'content_short')->widget(CKEditor::class, [
    'options' => ['rows' => 6],
]) ?>

<?= $form->field($model, 'content_full')->widget(CKEditor::class, [
    'options' => ['rows' => 6],
    'preset' => 'full'
]) ?>

<?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
</div>

<?php ActiveForm::end(); ?>
