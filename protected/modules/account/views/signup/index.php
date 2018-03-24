<?php
/* @var $this \yii\web\View */

/* @var $model \app\modules\account\models\SignupForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['class' => 'col-lg-6']]); /* @var $form \yii\bootstrap\ActiveForm */ ?>

<?= $form->field($model, 'username')->textInput() ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'repeatPassword')->passwordInput() ?>

<?= $form->field($model, 'verifyRules')->checkbox() ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>
