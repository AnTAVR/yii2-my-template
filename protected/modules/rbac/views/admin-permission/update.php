<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\rbac\models\Permission
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions Manager'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];

$this->title = Yii::t('yii', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
