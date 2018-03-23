<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\modules\products\models\Products */

$this->title = Yii::t('app', 'Update Products: {name}', ['name' => $model->content_title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
