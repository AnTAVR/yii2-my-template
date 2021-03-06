<?php

use app\modules\account\models\forms\RecoveryPasswordRequestForm;
use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model RecoveryPasswordRequestForm */

$this->title = Yii::t('app', 'Password Reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['class' => 'col-lg-6']]); ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'repeatPassword')->passwordInput() ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Send'),
        [
            'class' => 'btn btn-primary',
        ]) ?>
</div>

<?php ActiveForm::end(); ?>
