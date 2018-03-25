<?php

/* @var $this \yii\web\View */
/* @var $searchModel \app\modules\rbac\models\AssignmentSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        [
            'label' => 'Roles',
            'content' => function ($model) {
                $authManager = Yii::$app->authManager;
                $roles = [];
                foreach ($authManager->getRolesByUser($model->id) as $role) {
                    $roles[] = $role->name;
                }
                return $roles ? implode(',', $roles) : Yii::t('yii', '(not set)');
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'header' => Yii::t('app', 'Assignment'),
            'urlCreator' => function (/** @noinspection PhpUnusedParameterInspection */
                $action, $model, $key, $index) {
                return Url::to(['assignment', 'id' => $key]);
            },
        ],
    ],
]);
