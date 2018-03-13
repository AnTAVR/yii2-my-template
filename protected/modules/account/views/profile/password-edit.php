<?php
/* @var $this yii\web\View */

/* @var $model app\modules\account\models\PasswordEditForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Password Edit');

/** @var $identity \app\modules\account\models\User */
$identity = Yii::$app->user->identity;
$this->params['breadcrumbs'][] = ['label' => $identity->username, 'url' => ['/account']];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="account-profile-password-edit">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'password-edit-form']); /* @var $form yii\bootstrap\ActiveForm */ ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'verifyPassword')->passwordInput() ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
