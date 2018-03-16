<?php
/* @var $this \app\components\View */

/* @var $model \app\modules\account\models\PasswordForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Password Reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin(['id' => $this->uniqueId . '-form']); /* @var $form \yii\bootstrap\ActiveForm */ ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'repeatPassword')->passwordInput() ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
