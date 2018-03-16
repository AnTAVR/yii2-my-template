<?php
/* @var $this \app\components\View */

/* @var $model \app\models\CallbackForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Application for a callback');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Yii::t('app', 'Please fill in the following form and we will call you back.') ?>
    <br>
    <?= Yii::t('app', 'Thank you.') ?>
</p>

<div class="row">
    <div class="col-lg-6">

        <?php $form = ActiveForm::begin(['id' => 'callback-form']); /* @var $form \yii\bootstrap\ActiveForm */ ?>

        <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'callback-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
