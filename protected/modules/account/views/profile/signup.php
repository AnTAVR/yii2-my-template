<?php
/* @var $this yii\web\View */

/* @var $model app\modules\account\models\SignupForm */

use app\widgets\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="account-profile-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']); /* @var $form yii\bootstrap\ActiveForm */ ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'verifyPassword')->passwordInput() ?>

            <?= $form->field($model, 'verifyRules')->checkbox()->hint(Html::a(Yii::t('app', 'Rules'), ['/static/index', 'meta_url' => 'rules'], ['class' => 'label label-success', 'target' => '_blank'])) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
