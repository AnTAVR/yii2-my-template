<?php

/* @var $this \yii\web\View */

/* @var $model \app\modules\rbac\models\AssignmentForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$authManager = Yii::$app->authManager;
?>
<?php $form = ActiveForm::begin(); ?>
<?= Html::activeHiddenInput($model, 'userId') ?>

<label class="control-label"><?= $model->attributeLabels()['roles'] ?></label>

<input type="hidden" name="AssignmentForm[roles]" value="">

<table class="table table-striped table-bordered detail-view">
    <thead>
    <tr>
        <th style="width:1px"></th>
        <th style="width:150px">Name</th>
        <th>Description</th>
    </tr>
    <tbody>
    <?php foreach ($authManager->getRoles() as $role): ?>
        <tr>
            <?php
            $checked = true;
            if ($model->roles == null || !is_array($model->roles) || count($model->roles) == 0) {
                $checked = false;
            } else if (!in_array($role->name, $model->roles)) {
                $checked = false;
            }
            ?>
            <td><input <?= $checked ? "checked" : "" ?> type="checkbox" name="AssignmentForm[roles][]"
                                                        value="<?= $role->name ?>"></td>
            <td><?= $role->name ?></td>
            <td><?= $role->description ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

