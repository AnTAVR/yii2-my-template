<?php

use app\modules\callback\models\forms\CallbackForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model CallbackForm */

$this->title = Yii::t('app', 'Request for a call back');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Yii::t('app', 'Please fill in the following form and we will call you back.') ?>
    <br>
    <?= Yii::t('app', 'Thank you.') ?>
</p>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
