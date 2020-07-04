<?php

/* @var $this yii\web\View */

/* @var $model app\modules\rbac\models\forms\AssignmentForm */

use yii\helpers\Html;

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
