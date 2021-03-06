<?php

use app\modules\account\models\User;
use yii\web\Controller;
use yii\web\View;

/* @var $this View */
/** @var $identity User */

$identity = Yii::$app->user->identity;
$this->params['breadcrumbs'][] = ['label' => $identity->username, 'url' => ['/account']];

$this->params['breadcrumbs'][] = $this->title;

/* @var $context Controller */
$context = $this->context;
?>
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
