<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this \yii\web\View */
/* @var $data array */
/* @var $pagination yii\data\Pagination */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= LinkPager::widget(['pagination' => $pagination,]) ?>

<?php $i = 0;
$col = 1;
foreach ($data as $model) {
    /* @var $model \app\modules\articles\models\Articles */
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
