<?php
/* @var $this \yii\web\View */

/* @var $model \app\models\StaticPage */

use app\widgets\CKEditor\CKEditor;
use app\widgets\UrlTranslit\UrlTranslit;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); /* @var $form \yii\bootstrap\ActiveForm */ ?>

<?= $form->field($model, 'meta_url')->widget(UrlTranslit::class, [
    'fromField' => 'content_title',
    'options' => ['maxlength' => true]
]) ?>

<?= $form->field($model, 'content_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'content_full')->widget(CKEditor::class, [
    'options' => ['rows' => 6],
    'preset' => 'full'
]) ?>

<?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
