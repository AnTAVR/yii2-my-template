<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppSiteAsset;
use app\widgets\Alert;
use app\widgets\Thumbnail\Thumbnail;
use app\widgets\TopLink\TopLink;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$asset = AppSiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
$fixed_top = false;
NavBar::begin([
    'brandLabel' => Yii::t('app', 'View on site'),
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'target' => '_blank',
    ],
    'options' => [
        'class' => 'navbar-inverse' . ($fixed_top ? ' navbar-fixed-top' : ''),
    ],
]);
$menuItems = [
];

if (Yii::$app->user->isGuest) {
    $profileItems = ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-in"></span> ' .
        Yii::t('app', 'Login'), 'url' => [Yii::$app->user->loginUrl]];
} else {
    $profileItems = [];

    $profileItems = ArrayHelper::merge($profileItems, [
        ['label' => Yii::t('app', 'Profile'), 'url' => ['/account']],
        '<li class="divider"></li>',
        ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-out"></span> ' . Yii::t('app', 'Logout'),
            'url' => ['/logout'], 'linkOptions' => ['data' => ['method' => 'post']]],
    ]);

    /** @var $identity \app\modules\account\models\User */
    $identity = Yii::$app->user->identity;
    $profileItems = ['label' => $identity->username, 'items' => $profileItems,];
}

$menuItems[] =  $profileItems;

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
<div class="wrap<?= $fixed_top ? ' fixed-top' : '' ?>">
    <div class="container">

        <?= $this->render('admin_menu') ?>

        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Admin panel'), 'url' => ['/admin-site']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>

        <div class="content">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <span class="pull-left">&copy; <?= Yii::$app->params['brandLabel'] ?></span>&nbsp;
            <span class="pull-right"><?= date('Y') ?></span>
        </p>

        <p class="pull-right">
            <small>
                <small>
                    <?= Yii::t('app', 'All rights, including related copyrights are<br>reserved by the respective owners.') ?>
                </small>
            </small>
        </p>
    </div>
</footer>

<?= TopLink::widget() ?>
<?= Thumbnail::widget() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
