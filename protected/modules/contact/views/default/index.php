<?php
/* @var $this \yii\web\View */

/* @var $model \app\modules\contact\models\forms\ContactForm */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us.') ?>
    <?= Yii::t('app', 'Thank you.') ?></p>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
