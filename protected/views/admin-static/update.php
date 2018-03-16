<?php

use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $model \app\models\StaticPage */

$this->title = Yii::t('app', 'Update Static Page: {name}', ['name' => $model->content_title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['/admin-static']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
