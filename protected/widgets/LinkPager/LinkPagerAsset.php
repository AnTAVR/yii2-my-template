<?php

namespace app\widgets\LinkPager;

use yii\web\AssetBundle;

class LinkPagerAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/LinkPager/assets';

    public $js = [
        'jquery.linkpager.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
