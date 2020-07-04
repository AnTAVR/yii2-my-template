<?php

use app\modules\account\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/** @var $user User */

$this->title = $user->username;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= Yii::t('app', 'Profile') ?></h4>
    </div>
    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $user,
            'attributes' => [
                'id',
                'username',
                'email:email',
                'email_confirmed:boolean',
                'avatar:image',
                'status_txt',
                'created_at:datetime',
                [
                    'attribute' => 'created_ip',
                    'value' => Html::a($user->created_ip, 'http://ipinfo.io/' . $user->created_ip, ['target' => '_blank']),
                    'format' => 'raw',
                ],
                'last_login_at:datetime',
                'last_request_at:datetime',
            ],
        ]) ?>
    </div>
    <div class="panel-footer">
        <?= Html::a(Yii::t('yii', 'Delete'),
            ['delete'],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete account?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?= Html::a(Yii::t('app', 'Password Edit'),
            ['password-edit'],
            [
                'class' => 'btn btn-default',
            ]) ?>
    </div>
</div>
