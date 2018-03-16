<?php
/* @var $this \app\components\View */

/* @var $model \app\models\ContactForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Feedback');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us.') ?>
    <?= Yii::t('app', 'Thank you.') ?></p>

<div class="row">
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin(['id' => $this->uniqueId . '-form']); /* @var $form \yii\bootstrap\ActiveForm */ ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'subject') ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
