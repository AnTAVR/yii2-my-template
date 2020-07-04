<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rbac\models\searches\RuleSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Roles Manager');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('../menu.php') ?>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create'),
        ['create'],
        [
            'class' => 'btn btn-success',
        ]) ?>
</p>

<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'description',
        [
            'label' => $searchModel->attributeLabels()['ruleName'],
            'value' => function ($model) {
                return $model->ruleName == null ? Yii::t('app', '(not use)') : $model->ruleName;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
            'urlCreator' => function (/** @noinspection PhpUnusedParameterInspection */
                $action, $model, $key, $index) {
                return Url::to([$action, 'name' => $key]);
            },
//            'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii', 'View'), 'data-toggle' => 'tooltip'],
//            'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii', 'Update'), 'data-toggle' => 'tooltip'],
//            'deleteOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii', 'Delete'),
//                'data-confirm' => false, 'data-method' => false, // for override yii data api
//                'data-request-method' => 'post',
//                'data-toggle' => 'tooltip',
//                'data-confirm-ok' => Yii::t('app', 'Ok'),
//                'data-confirm-cancel' => Yii::t('app', 'Cancel'),
//                'data-confirm-title' => Yii::t('app', 'Are you sure?'),
//                'data-confirm-message' => Yii::t('app', 'Are you sure you want to delete this item?')],
        ],
    ],
])
?>
