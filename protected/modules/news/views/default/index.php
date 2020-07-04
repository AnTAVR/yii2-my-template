<?php

use app\modules\news\models\News;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/* @var $this View */
/* @var $data array */
/* @var $pagination Pagination */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= LinkPager::widget(['pagination' => $pagination,]) ?>

<?php $i = 0;
$col = 1;
foreach ($data as $model) {
    /* @var $model News */
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
