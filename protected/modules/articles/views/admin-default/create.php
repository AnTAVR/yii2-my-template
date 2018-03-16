<?php

use yii\helpers\Html;


/* @var $this \app\components\View */
/* @var $model \app\modules\articles\models\Articles */

$this->title = Yii::t('app', 'Create Articles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
