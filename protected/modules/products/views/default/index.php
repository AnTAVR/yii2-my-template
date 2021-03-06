<?php

use app\modules\products\models\Category;
use app\modules\products\models\Products;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/* @var $this View */
/* @var $data array */
/* @var $pagination Pagination */
/* @var $category Category */

if ($category == null) {
    $title = Yii::t('app', 'Products');
} else {
    $title = $category->content_title;
}

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php
if ($category !== null and $category->content_full) {
    echo '<div class="panel-body">' . $category->content_full . '</div>';
}
?>

<?= LinkPager::widget(['pagination' => $pagination,]) ?>


<?php $i = 0;
$col = 1;
foreach ($data as $model) {
    /* @var $model Products */
    if (!$i) {
        echo '<div class="row">', "\n";
        $open = true;
    }
    echo $this->render('_index', ['model' => $model, 'class' => 'col-sm-6']);
    if ($i >= $col) {
        echo '</div>', "\n\n";
        $i = 0;
    } else {
        $i++;
    }
}
if ($i) {
    echo '</div>', "\n\n";
}
?>

<?= LinkPager::widget(['pagination' => $pagination,]) ?>
