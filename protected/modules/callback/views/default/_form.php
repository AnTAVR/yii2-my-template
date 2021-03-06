<?php

use app\modules\callback\models\forms\CallbackForm;
use app\widgets\Captcha;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model CallbackForm */

?>
<?php $form = ActiveForm::begin(['id' => 'callback-form', 'options' => ['class' => 'col-lg-6']]); ?>

<?= $form->field($model, 'phone')->widget(PhoneInput::class, [
    'jsOptions' => [
        'preferredCountries' => Yii::$app->params['phone.countries'],
    ]
]) ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Send'),
        [
            'class' => 'btn btn-primary',
        ]) ?>
</div>

<?php ActiveForm::end(); ?>
