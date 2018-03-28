<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;

$controllerId = Yii::$app->controller->id;

?>
<p>
    <?= $controllerId !== 'admin-assignment' ? Html::a(Yii::t('app', 'User Assignment'),
        ['/rbac/admin-assignment'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
    <?= $controllerId !== 'admin-permission' ? Html::a(Yii::t('app', 'Permissions Manager'),
        ['/rbac/admin-permission'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
    <?= $controllerId !== 'admin-role' ? Html::a(Yii::t('app', 'Roles Manager'),
        ['/rbac/admin-role'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
    <?= $controllerId !== 'admin-rule' ? Html::a(Yii::t('app', 'Rules Manager'),
        ['/rbac/admin-rule'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
</p>
