<?php

use yii\bootstrap\Nav;
use yii\web\View;

/* @var $this View */

$controllerId = Yii::$app->controller->id;
$moduleId = Yii::$app->controller->module->id;
$user = Yii::$app->user;
?>
<?= Nav::widget([
    'options' => ['class' => 'nav nav-tabs'],
    'items' => [
        ['label' => Yii::t('app', 'Dump DB'),
            'active' => $moduleId === 'dump' && $controllerId === 'admin-default',
            'visible' => $user->can('dump.openAdminPanel'),
            'url' => ['/dump/admin-default']],

        ['label' => Yii::t('app', 'RBAC'),
            'active' => $moduleId === 'rbac',
            'visible' => $user->can('rbac.openAdminPanel'),
            'url' => ['/rbac/admin-default'],
            'items' => [
                ['label' => Yii::t('app', 'User Assignment'),
                    'active' => $moduleId === 'rbac' && $controllerId === 'admin-assignment',
                    'url' => ['/rbac/admin-assignment']],

                ['label' => Yii::t('app', 'Permissions Manager'),
                    'active' => $moduleId === 'rbac' && $controllerId === 'admin-permission',
                    'url' => ['/rbac/admin-permission']],

                ['label' => Yii::t('app', 'Roles Manager'),
                    'active' => $moduleId === 'rbac' && $controllerId === 'admin-role',
                    'url' => ['/rbac/admin-role']],

                ['label' => Yii::t('app', 'Rules Manager'),
                    'active' => $moduleId === 'rbac' && $controllerId === 'admin-rule',
                    'url' => ['/rbac/admin-rule']],
            ],
        ],

        ['label' => Yii::t('app', 'Static Pages'),
            'active' => $moduleId === 'statics',
            'visible' => $user->can('statics.openAdminPanel'),
            'url' => ['/statics/admin-default']],

        ['label' => Yii::t('app', 'News'),
            'active' => $moduleId === 'news',
            'visible' => $user->can('news.openAdminPanel'),
            'url' => ['/news/admin-default']],

        ['label' => Yii::t('app', 'Articles'),
            'active' => $moduleId === 'articles',
            'visible' => $user->can('articles.openAdminPanel'),
            'url' => ['/articles/admin-default']],

        ['label' => Yii::t('app', 'Products'),
            'active' => $moduleId === 'products',
            'visible' => $user->can('products.openAdminPanel'),
            'url' => ['/products/admin-default'],
            'items' => [
                ['label' => Yii::t('app', 'Category'),
                    'active' => $moduleId === 'products' && $controllerId === 'admin-category',
                    'url' => ['/products/admin-category']],

                ['label' => Yii::t('app', 'Product'),
                    'active' => $moduleId === 'products' && $controllerId === 'admin-product',
                    'url' => ['/products/admin-product']],
            ]
        ],

        ['label' => Yii::t('app', 'Uploader'),
            'active' => $moduleId === 'uploader',
            'visible' => $user->can('uploader.openAdminPanel'),
            'url' => ['/uploader/admin-default'],
            'items' => [
                ['label' => Yii::t('app', 'Uploader Images'),
                    'active' => $moduleId === 'uploader' && $controllerId === 'admin-images',
                    'url' => ['/uploader/admin-images']],

                ['label' => Yii::t('app', 'Uploader Files'),
                    'active' => $moduleId === 'uploader' && $controllerId === 'admin-files',
                    'url' => ['/uploader/admin-files']],
            ]
        ],
    ],
]) ?>

