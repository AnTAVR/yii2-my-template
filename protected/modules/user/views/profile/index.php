<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $identity \app\modules\user\models\User */
$identity = Yii::$app->user->identity;

$this->title = $identity->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?= Yii::t('app', 'Profile') ?></h4>
        </div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $identity,
                'attributes' => [
                    'id',
                    'username',
                    'password',
                ],
            ]) ?>
        </div>
        <div class="panel-footer">
            <?= Html::a(Yii::t('app', 'Edit'), ['edit'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
