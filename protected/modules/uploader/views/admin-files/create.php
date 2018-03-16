<?php

use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \app\components\View */
/* @var $model \app\modules\uploader\models\UploaderFileForm */

$this->title = Yii::t('app', 'Create File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="uploader-form">

    <?php $form = ActiveForm::begin(['id' => $this->uniqueId . '-form', 'options' => ['enctype' => 'multipart/form-data']]); /* @var $form \yii\bootstrap\ActiveForm */ ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'autofocus' => true]) ?>

    <?= $form->field($model, 'fileUpload')->widget(FileUploadUI::class, [
        'url' => ['upload'],
        'formView' => '@app/modules/uploader/views/form',
        'gallery' => false,
        'fieldOptions' => [
            'multiple' => false,
            'accept' => '*',
        ],
        'clientOptions' => [
            'maxFileSize' => $model::MAX_SIZE,
        ],
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
            'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        ],
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
