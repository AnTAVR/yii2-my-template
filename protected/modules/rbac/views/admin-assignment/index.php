<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \app\modules\rbac\models\AssignmentSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Assignment');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app', 'Permissions Manager'), ['/rbac/admin-permission'], ['class' => 'btn btn-default']) ?>
    <?= Html::a(Yii::t('app', 'Roles Manager'), ['/rbac/admin-role'], ['class' => 'btn btn-default']) ?>
    <?= Html::a(Yii::t('app', 'Rules Manager'), ['/rbac/admin-rule'], ['class' => 'btn btn-default']) ?>
</p>

<?= GridView::widget([
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
]) ?>

