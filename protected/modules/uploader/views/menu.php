<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;

$controllerId = Yii::$app->controller->id;

?>
<p>
    <?= $controllerId !== 'admin-files' ? Html::a(Yii::t('app', 'Uploader Files'),
        ['/uploader/admin-files'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
    <?= $controllerId !== 'admin-images' ? Html::a(Yii::t('app', 'Uploader Images'),
        ['/uploader/admin-images'],
        [
            'class' => 'btn btn-default',
        ]) : '' ?>
</p>
