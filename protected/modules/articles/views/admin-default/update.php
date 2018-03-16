<?php

use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $model app\modules\articles\models\Articles */

$this->title = Yii::t('app', 'Update Articles: {name}', ['name' => $model->content_title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="articles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
