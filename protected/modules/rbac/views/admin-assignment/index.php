<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $searchModel \app\modules\rbac\models\searches\AssignmentSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('@app/modules/rbac/views/menu.php') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'rolesTxt:raw',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]) ?>

