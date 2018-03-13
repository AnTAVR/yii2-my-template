<?php
/* @var $this yii\web\View */

/** @var $identity \app\modules\account\models\User */
$identity = Yii::$app->user->identity;
$this->params['breadcrumbs'][] = ['label' => $identity->username, 'url' => ['/account']];

$this->params['breadcrumbs'][] = $this->title;

/* @var $context yii\web\Controller */
$context = $this->context;
?>
<div class="account-profile-edit">
    <h1><?= $context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $context->action->id ?>".
        The action belongs to the controller "<?= get_class($context) ?>"
        in the "<?= $context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
