<?php

/* @var $this yii\web\View */

/* @var $model app\modules\rbac\models\Role */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$rules = Yii::$app->authManager->getRules();
$rulesNames = array_keys($rules);
$rulesDatas = array_merge(['' => Yii::t('app', '(not use)')], array_combine($rulesNames, $rulesNames));

$authManager = Yii::$app->authManager;
$permissions = $authManager->getPermissions();
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>

<?= $form->field($model, 'ruleName')->dropDownList($rulesDatas) ?>

<div class="form-group field-role-permissions">
    <label class="control-label" for="role-permissions">Permissions</label>
    <input type="hidden" name="Role[permissions]" value="">
    <div id="role-permissions">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td style="width:1px"></td>
                <td style="width:1px"><b>Name</b></td>
                <td><b>Description</b></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td>
                        <input <?= in_array($permission->name, $model->permissions) ? "checked" : "" ?> type="checkbox"
                                                                                                        name="Role[permissions][]"
                                                                                                        value="<?= $permission->name ?>">
                    </td>
                    <td><?= $permission->name ?></td>
                    <td><?= $permission->description ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="help-block"></div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
</div>

<?php ActiveForm::end(); ?>
