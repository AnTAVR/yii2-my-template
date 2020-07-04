<?php

use app\modules\rbac\models\forms\AssignmentForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model AssignmentForm */

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
