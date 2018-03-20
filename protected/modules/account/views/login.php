<?php
/* @var $this \app\components\View */

/* @var $model \app\modules\account\models\LoginForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>

<?php $form = ActiveForm::begin(['options' => ['class' => 'col-lg-6']]); /* @var $form \yii\bootstrap\ActiveForm */ ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
