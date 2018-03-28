<?php

/* @var $this \yii\web\View */

use yii\bootstrap\Nav;

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
