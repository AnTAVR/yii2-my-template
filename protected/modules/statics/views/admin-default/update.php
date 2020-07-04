<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\statics\models\StaticPage */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['/statics/admin-default']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

$this->title = Yii::t('yii', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
