<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\models\StaticPage */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['index']];

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
