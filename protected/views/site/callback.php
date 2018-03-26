<?php
/* @var $this \yii\web\View */

/* @var $model \app\models\forms\CallbackForm */

use app\widgets\Captcha;
use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Request for a call back');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Yii::t('app', 'Please fill in the following form and we will call you back.') ?>
    <br>
    <?= Yii::t('app', 'Thank you.') ?>
</p>

<?php $form = ActiveForm::begin(['id' => 'callback-form', 'options' => ['class' => 'col-lg-6']]); ?>

<?= $form->field($model, 'phone')->widget(PhoneInput::class, [
    'jsOptions' => [
        'preferredCountries' => Yii::$app->params['phone.countries'],
    ]
]) ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'callback-button']) ?>
</div>

<?php ActiveForm::end(); ?>
