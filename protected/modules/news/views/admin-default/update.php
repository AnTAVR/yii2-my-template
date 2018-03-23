<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\modules\news\models\News */

$this->title = Yii::t('app', 'Update News: {name}', ['name' => $model->content_title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
