<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\account\models\LoginForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?php
            $module = Yii::$app->getModule('account');
            if ($module->params['signup']) {
                echo $form->field($model, 'username')->textInput(['autofocus' => true])->hint(Html::a(Yii::t('app', 'Signup'), ['/account/signup'], ['class' => 'label label-success']));
            } else {
                echo $form->field($model, 'username')->textInput(['autofocus' => true]);
            }
            ?>

            <?= $form->field($model, 'password')->passwordInput([''])->hint(Html::a(Yii::t('app', 'Password Reset'), ['/account/signup/password-reset'], ['class' => 'label label-danger'])) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
