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

<p>
    <?= Html::a(Yii::t('app', 'Permissions Manager'),
        ['/rbac/admin-permission'],
        [
            'class' => 'btn btn-default',
        ]) ?>
    <?= Html::a(Yii::t('app', 'Roles Manager'),
        ['/rbac/admin-role'],
        [
            'class' => 'btn btn-default'
            ,]) ?>
    <?= Html::a(Yii::t('app', 'Rules Manager'),
        ['/rbac/admin-rule'],
        [
            'class' => 'btn btn-default',
        ]) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'rolesTxt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
        ],
    ],
]) ?>

