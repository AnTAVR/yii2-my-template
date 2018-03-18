<?php
/* @var $this \app\components\View */

/** @var $identity \app\modules\account\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $identity->username;

$this->params['breadcrumbs'][] = $this->title;
?>
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
                'email:email',
                'email_confirmed:boolean',
                'foto:image',
                'status_txt',
                'created_at',
                'created_ip',
                'session_at',
            ],
        ]) ?>
    </div>
    <div class="panel-footer">
        <?= Html::a(Yii::t('app', 'Password Edit'), ['password-edit'], ['class' => 'btn btn-default']) ?>
    </div>
</div>
