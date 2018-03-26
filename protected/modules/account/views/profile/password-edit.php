<?php
/* @var $this \yii\web\View */

/* @var $model \app\modules\account\models\forms\PasswordEditForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Password Edit');

/** @var $identity \app\modules\account\models\User */
$identity = Yii::$app->user->identity;
$this->params['breadcrumbs'][] = ['label' => $identity->username, 'url' => ['/account']];

$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['class' => 'col-lg-6']]); ?>

<?= $form->field($model, 'oldPassword')->passwordInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'repeatPassword')->passwordInput() ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
