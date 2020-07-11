<?php

use app\assets\AppSiteAsset;
use app\modules\account\models\User;
use app\modules\rbac\helpers\RBAC;
use app\widgets\Thumbnail\Thumbnail;
use app\widgets\TopLink\TopLink;
use yii\bootstrap\Carousel;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\View;
use yii\widgets\Breadcrumbs;

//use app\modules\articles\widgets\ArticlesMenu;
//use app\modules\news\widgets\NewsMenu;
//use app\modules\products\widgets\ProductsMenu;

/* @var $this View */
/* @var $content string */

$asset = AppSiteAsset::register($this);
/** @var AssetBundle $asset */
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
    'brandLabel' => Yii::$app->params['brandLabel'],
    'brandUrl' => Yii::$app->homeUrl,
    'headerContent' => '<div class="navbar-text">' . Yii::$app->params['brandLabelText'] . '</div>',
    'options' => [
        'class' => 'navbar-default' . ($fixed_top ? ' navbar-fixed-top' : ''),
    ],
]); ?>

<?php
$menuItems = [
];

$profileItems = [];
if (Yii::$app->user->isGuest) {
    $profileItems = ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-in"></span> ' .
        Yii::t('app', 'Login'), 'url' => ['/site/login']];
} else {
    if (Yii::$app->user->can(RBAC::ADMIN_PERMISSION)) {
        $profileItems = [
            ['label' => Yii::t('app', 'Admin panel'), 'url' => ['/admin-site'], 'linkOptions' => ['target' => '_blank']],
            '<li class="divider"></li>',
        ];
    }
    $profileItems = ArrayHelper::merge($profileItems, [
        ['label' => Yii::t('app', 'Profile'), 'url' => ['/account']],
        '<li class="divider"></li>',
        ['encode' => false, 'label' => '<span class="glyphicon glyphicon-log-out"></span> ' . Yii::t('app', 'Logout'),
            'url' => ['/site/logout'], 'linkOptions' => ['data' => ['method' => 'post']]],
    ]);

    /** @var $identity User */
    $identity = Yii::$app->user->identity;
    $profileItems = ['label' => $identity->username, 'items' => $profileItems,];
}

//if (!Yii::$app->user->isGuest) {
$menuItems[] = $profileItems;
//}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);

echo $this->render('@app/views/layouts/_yandex.translate.php');

NavBar::end();
?>
<div class="wrap<?= $fixed_top ? ' fixed-top' : '' ?>">
    <div class="container">
        <?= Carousel::widget([
            'showIndicators' => true,
            'controls' => [
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                '',
                '',
            ],
            'items' => [
                [
                    'content' => Html::img($asset->baseUrl . '/css/carousel1.png'),
                    'caption' => '<h1>This is title 1</h1><p>This is the caption text</p>',
                ],
                [
                    'content' => Html::img($asset->baseUrl . '/css/carousel2.png'),
                    'caption' => '<h2>This is title 2</h2><p>This is the caption text</p>',
                ],
                [
                    'content' => Html::img($asset->baseUrl . '/css/carousel3.png'),
                    'caption' => '<h3>This is title 3</h3><p>This is the caption text</p>',
                ],
            ]
        ]);
        ?>
        <?php
        $menuItems = [
            ['label' => Yii::t('app', 'О компании'),
                'items' => [
                    ['label' => Yii::t('app', 'Docs'), 'url' => ['/statics/default/index', 'meta_url' => 'docs']],
                    ['label' => Yii::t('app', 'История'), 'url' => ['/statics/default/index', 'meta_url' => 'history']],
                    ['label' => Yii::t('app', 'Приоритеты'), 'url' => ['/statics/default/index', 'meta_url' => 'prioritets']],
                ],
            ],
        ];
        $menuItems = ArrayHelper::merge($menuItems, [
            ['label' => Yii::t('app', 'Продукты'),
                'items' => [
                    ['label' => Yii::t('app', 'Гипер и вибропрессование'), 'url' => ['/products']],
                    ['label' => Yii::t('app', 'Строительство'), 'url' => ['/statics/default/index', 'meta_url' => 'docs']],
                    ['label' => Yii::t('app', 'Производство'), 'url' => ['/statics/default/index', 'meta_url' => 'delivery']],
                    '<li class="divider"></li>',
//                    '<li class="dropdown-header">Dropdown Header</li>',
                    ['label' => Yii::t('app', 'Сейсмика'), 'url' => ['/statics/default/index', 'meta_url' => 'payment']],
                    ['label' => Yii::t('app', 'Аэродромы'), 'url' => ['/contact']],
                    ['label' => Yii::t('app', 'Гидробетон'), 'url' => ['/callback']],
                ],
            ],
        ]);

        $menuItems = ArrayHelper::merge($menuItems, [
            ['label' => Yii::t('app', 'Партнеры'),
                'items' => [
                    ['label' => Yii::t('app', 'Карта Евразии'), 'url' => ['/statics/default/index', 'meta_url' => 'euromap']],
                    ['label' => Yii::t('app', 'Отзывы'), 'url' => ['/statics/default/index', 'meta_url' => 'comments']],
                    ['label' => Yii::t('app', 'Оставить отзыв'), 'url' => ['/statics/default/index', 'meta_url' => 'comments']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Партнерам'), 'url' => ['/statics/default/index', 'meta_url' => 'partners']],
                ],
            ],
            ['label' => Yii::t('app', 'Карьера'),
                'items' => [
                    ['label' => Yii::t('app', 'Вакансии'), 'url' => ['/statics/default/index', 'meta_url' => 'vakansii']],
                    ['label' => Yii::t('app', 'Условия работы'), 'url' => ['/statics/default/index', 'meta_url' => 'docs']],
                    ['label' => Yii::t('app', 'Выслать резюме'), 'url' => ['/statics/default/index', 'meta_url' => 'delivery']],
                    ['label' => Yii::t('app', 'Для студентов'), 'url' => ['/statics/default/index', 'meta_url' => 'payment']],
                    ['label' => Yii::t('app', 'Совместителем'), 'url' => ['/statics/default/index', 'meta_url' => 'payment']],
                ],
            ],
            ['label' => Yii::t('app', 'Contacts'), 'url' => ['/statics/default/index', 'meta_url' => 'about']],
            ['label' => Yii::t('app', 'Новости'),
                'items' => [
                    ['label' => Yii::t('app', 'About'), 'url' => ['/statics/default/index', 'meta_url' => 'about']],
                    ['label' => Yii::t('app', 'Docs'), 'url' => ['/statics/default/index', 'meta_url' => 'docs']],
                    ['label' => Yii::t('app', 'Delivery'), 'url' => ['/statics/default/index', 'meta_url' => 'delivery']],
                    ['label' => Yii::t('app', 'Payment'), 'url' => ['/statics/default/index', 'meta_url' => 'payment']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Contact'), 'url' => ['/contact']],
                    ['label' => Yii::t('app', 'Callback'), 'url' => ['/callback']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Partners'), 'url' => ['/statics/default/index', 'meta_url' => 'partners']],
                ],
            ],
        ]);

        //$menuItems[] = ['encode' => false, 'label' => NewsMenu::widget()];
        //$menuItems[] = ['encode' => false, 'label' => ArticlesMenu::widget()];

        echo Nav::widget([
            'options' => ['class' => 'nav nav-pills'],
            'items' => $menuItems,
        ]);

        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);

        ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <span class="pull-left">&copy; <?= Yii::$app->params['brandLabel'] ?></span>&nbsp;
            <span class="pull-right"><?= date('Y') ?></span>
        </p>

        <?= $this->render('@app/views/layouts/_yandex.counter.php') ?>

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
