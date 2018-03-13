<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppSiteAsset;
use app\widgets\Thumbnail\Thumbnail;
use app\widgets\TopLink\TopLink;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

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
NavBar::begin([
    'brandLabel' => Yii::t('app', 'View site'),
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'target' => '_blank',
    ],
    'options' => [
        'class' => 'navbar-inverse',
    ],
]);
$menuItems = [
];

if (Yii::$app->user->isGuest) {
    $profileItems = ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-in"></span> ' .
        Yii::t('app', 'Login'), 'url' => [Yii::$app->user->loginUrl]];
} else {
    $profileItems = [];

    $profileItems = array_merge($profileItems, [
        ['label' => Yii::t('app', 'Profile'), 'url' => ['/account']],
        '<li class="divider"></li>',
        ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-out"></span> ' .
            Yii::t('app', 'Logout'), 'url' => ['/account/profile/logout']],
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
$controllerId = Yii::$app->controller->id;
$moduleId = Yii::$app->controller->module->id;
?>
<div class="wrap">
    <div class="container">
        <?= Menu::widget([
            'options' => ['class' => 'nav nav-tabs'],
            'items' => [
                ['label' => Yii::t('app', 'Static Pages'),
                    'active' => $controllerId === 'admin-static',
                    'url' => ['/admin-static']],
                ['label' => Yii::t('app', 'News'),
                    'active' => $moduleId === 'news',
                    'url' => ['/news/admin-default']],
                ['label' => Yii::t('app', 'Articles'),
                    'active' => $moduleId === 'articles',
                    'url' => ['/articles/admin-default']],
                ['label' => Yii::t('app', 'Products'),
                    'active' => $moduleId === 'products',
                    'url' => ['/products/admin-default']],
                ['label' => Yii::t('app', 'Uploader Images'),
                    'active' => $moduleId === 'uploader' and $controllerId === 'admin-images',
                    'url' => ['/uploader/admin-images']],
                ['label' => Yii::t('app', 'Uploader Files'),
                    'active' => $moduleId === 'uploader' and $controllerId === 'admin-files',
                    'url' => ['/uploader/admin-files']],
            ],
        ]) ?>
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Admin panel'), 'url' => ['/admin-site']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>
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
