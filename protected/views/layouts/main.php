<?php

use app\modules\articles\widgets\ArticlesMenu;
use app\modules\products\widgets\ProductsMenu;
use app\widgets\Alert;
use yii\web\View;

/* @var $this View */
/* @var $content string */

?>
<?php $this->beginContent('@app/views/layouts/_main.php'); ?>

<div class="col-sm-3">
    <?= ProductsMenu::widget() ?>
    <?= ArticlesMenu::widget() ?>
</div>

<div class="col-sm-9">
    <?= Alert::widget() ?>

    <div class="content">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>
