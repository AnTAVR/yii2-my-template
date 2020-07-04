<?php

use app\modules\articles\models\Articles;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Articles */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
