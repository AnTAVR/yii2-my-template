<?php

use app\modules\news\models\News;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model News */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
