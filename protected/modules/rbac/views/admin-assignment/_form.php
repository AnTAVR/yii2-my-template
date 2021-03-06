<?php

use app\modules\rbac\models\forms\AssignmentForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model AssignmentForm */

$authManager = Yii::$app->authManager;
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'userId')->textInput() ?>

<?= $form->field($model, 'roles')->checkboxList(ArrayHelper::map($authManager->getRoles(), 'name', 'name'), [
    'separator' => '<br>',
//    'item' => fu,
]) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'),
        [
            'class' => 'btn btn-primary',
        ]) ?>
</div>
<?php ActiveForm::end(); ?>
