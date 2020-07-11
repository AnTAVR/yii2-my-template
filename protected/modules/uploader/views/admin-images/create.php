<?php

use app\modules\uploader\models\forms\UploaderImageForm;
use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model UploaderImageForm */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploader Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'fileUpload',
    'url' => ['upload'],
    'formView' => '@app/modules/uploader/views/form',
    'gallery' => false,
    'fieldOptions' => [
        'accept' => $model::ACCEPT,
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
