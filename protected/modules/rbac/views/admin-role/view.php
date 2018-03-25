<?php

/* @var $this \yii\web\View */

/* @var $model \app\modules\rbac\models\Role */

use app\modules\rbac\models\Role;

$permissions = Role::getPermissions($model->name);
$first = '';
$rows = [];
foreach ($permissions as $permission) {
    if (empty($first)) {
        $first = $permission->name;
    } else {
        $rows[] = '<tr><td>' . $permission->name . '</td></tr>';
    }
}
?>
<table class="table table-striped table-bordered detail-view">
    <tbody>
    <tr>
        <th><?= $model->attributeLabels()['name'] ?></th>
        <td><?= $model->name ?></td>
    </tr>
    <tr>
        <th><?= $model->attributeLabels()['description'] ?></th>
        <td><?= $model->description ?></td>
    </tr>
    <tr>
        <th><?= $model->attributeLabels()['ruleName'] ?></th>
        <td><?= $model->ruleName == null ? '<span class="text-danger">' . Yii::t('app', '(not use)') . '</span>' : $model->ruleName ?></td>
    </tr>
    <tr>
        <th rowspan="<?= count($permissions) ?>"><?= $model->attributeLabels()['permissions'] ?></th>
        <td><?= $first ?></td>
    </tr>
    <?= implode("", $rows) ?>
</table>
