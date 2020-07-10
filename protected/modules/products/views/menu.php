<?php

use yii\bootstrap\Nav;
use yii\web\View;

/* @var $this View */

$controllerId = Yii::$app->controller->id;

?>
<p>
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => Yii::t('app', 'Category'),
                'active' => $controllerId === 'admin-category',
                'url' => ['/products/admin-category']],
            ['label' => Yii::t('app', 'Product'),
                'active' => $controllerId === 'admin-product',
                'url' => ['/products/admin-product']],
        ],
    ]) ?>
</p>
