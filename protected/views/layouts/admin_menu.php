<?php

/* @var $this \yii\web\View */

use yii\widgets\Menu;

$controllerId = Yii::$app->controller->id;
$moduleId = Yii::$app->controller->module->id;

?>
<?= Menu::widget([
    'options' => ['class' => 'nav nav-tabs'],
    'items' => [
        ['label' => Yii::t('app', 'Dump DB'),
            'active' => $controllerId === 'admin-dump',
            'url' => ['/admin-dump']],
        ['label' => Yii::t('app', 'RBAC'),
            'active' => $moduleId === 'rbac',
            'url' => ['/rbac']],
        ['label' => Yii::t('app', 'Static Pages'),
            'active' => $controllerId === 'admin-static',
            'url' => ['/admin-static']],
        ['label' => Yii::t('app', 'News'),
            'active' => $moduleId === 'news',
            'url' => ['/news/admin-default']],
        ['label' => Yii::t('app', 'Articles'),
            'active' => $moduleId === 'articles',
            'url' => ['/articles/admin-default']],
        ['label' => Yii::t('app', 'Products'),
            'active' => $moduleId === 'products',
            'url' => ['/products/admin-default']],
        ['label' => Yii::t('app', 'Uploader Images'),
            'active' => $moduleId === 'uploader' && $controllerId === 'admin-images',
            'url' => ['/uploader/admin-images']],
        ['label' => Yii::t('app', 'Uploader Files'),
            'active' => $moduleId === 'uploader' && $controllerId === 'admin-files',
            'url' => ['/uploader/admin-files']],
    ],
]) ?>

