<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \app\modules\rbac\models\searches\AuthItemSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Roles Manager');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
            'urlCreator' => function (/** @noinspection PhpUnusedParameterInspection */
                $action, $model, $key, $index) {
                return Url::to([$action, 'name' => $key]);
            },
//            'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app', 'View'), 'data-toggle' => 'tooltip'],
//            'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app', 'Update'), 'data-toggle' => 'tooltip'],
//            'deleteOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app', 'Delete'),
//                'data-confirm' => false, 'data-method' => false, // for overide yii data api
//                'data-request-method' => 'post',
//                'data-toggle' => 'tooltip',
//                'data-comfirm-ok' => Yii::t('app', 'Ok'),
//                'data-comfirm-cancel' => Yii::t('app', 'Cancel'),
//                'data-confirm-title' => Yii::t('app', 'Are you sure?'),
//                'data-confirm-message' => Yii::t('app', 'Are you sure want to delete this item')],
        ],
    ],
])
?>
