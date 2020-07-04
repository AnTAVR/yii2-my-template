<?php

use app\modules\contact\models\forms\ContactForm;
use app\widgets\Captcha;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ContactForm */

?>
<?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'col-lg-6']]); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'subject') ?>

<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Send'),
        [
            'class' => 'btn btn-primary',
        ]) ?>
</div>

<?php ActiveForm::end(); ?>
