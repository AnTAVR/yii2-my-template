<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Uploader');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('@app/modules/uploader/views/menu.php') ?>
