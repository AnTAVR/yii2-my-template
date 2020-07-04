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
            ['label' => Yii::t('app', 'Uploader Files'),
                'active' => $controllerId === 'admin-files',
                'url' => ['/uploader/admin-files']],
            ['label' => Yii::t('app', 'Uploader Images'),
                'active' => $controllerId === 'admin-images',
                'url' => ['/uploader/admin-images']],
        ],
    ]) ?>
</p>
