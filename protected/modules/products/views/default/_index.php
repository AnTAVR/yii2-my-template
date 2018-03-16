<?php

use yii\helpers\Html;

/* @var $this \app\components\View */
/* @var $model app\modules\products\models\Products */
/* @var $class string */

?>
<div class="<?= $class ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?= Html::encode($model->content_title) ?></h4>
        </div>
        <div class="panel-body">
            <?= $model->content_short ?>
        </div>
        <div class="panel-footer">
            <?= Html::a(Yii::t('app', 'More') . ' &raquo', ['view', 'meta_url' => $model->meta_url], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
