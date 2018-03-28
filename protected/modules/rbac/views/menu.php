<?php

/* @var $this \yii\web\View */

use yii\bootstrap\Nav;

$controllerId = Yii::$app->controller->id;

?>
<p>
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => Yii::t('app', 'User Assignment'),
                'active' => $controllerId === 'admin-assignment',
                'url' => ['/rbac/admin-assignment']],
            ['label' => Yii::t('app', 'Permissions Manager'),
                'active' => $controllerId === 'admin-permission',
                'url' => ['/rbac/admin-permission']],
            ['label' => Yii::t('app', 'Roles Manager'),
                'active' => $controllerId === 'admin-role',
                'url' => ['/rbac/admin-role']],
            ['label' => Yii::t('app', 'Rules Manager'),
                'active' => $controllerId === 'admin-rule',
                'url' => ['/rbac/admin-rule']],
        ],
    ]) ?>
</p>
