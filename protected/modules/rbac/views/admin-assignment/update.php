<?php

/* @var $this \yii\web\View */

/* @var $model \app\modules\rbac\models\forms\AssignmentForm */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;

$authManager = Yii::$app->authManager;

$roles = ArrayHelper::map($authManager->getRoles(), 'name', 'name');

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'userId')->textInput() ?>

<?= $form->field($model, 'roles')->checkboxList($roles, [
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

