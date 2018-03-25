<?php

/* @var $this \yii\web\View */
/* @var $model \app\modules\rbac\models\Permission */
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
    <?php
    /*
    <tr><th><?= $model->attributeLabels()['data'] ?></th><td><?= $model->data ?></td></tr>
     */

    ?>
    </tbody>
</table>
