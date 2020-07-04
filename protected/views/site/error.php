<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = $name;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="alert alert-danger">
    <?= nl2br(Html::encode($message)) ?>
</div>

<p>
    <?= Yii::t('app', 'The above error occurred while the Web server was processing your request.') ?>
</p>
<p>
    <?= Yii::t('app', 'Please contact us if you think this is a server error.') ?>
    <?= Yii::t('app', 'Thank you.') ?><br>
    <?= Html::a(Yii::t('app', 'Back to Home'), Yii::$app->homeUrl) ?><br>
</p>
