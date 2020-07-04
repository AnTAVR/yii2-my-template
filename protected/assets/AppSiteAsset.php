<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppSiteAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/site.js',
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
}
