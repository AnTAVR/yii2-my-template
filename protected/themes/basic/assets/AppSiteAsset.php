<?php

namespace app\themes\basic\assets;

use app\themes\BasicTheme as Theme;
use yii\web\AssetBundle;

class AppSiteAsset extends AssetBundle
{
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/site.js',
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
    public function init()
    {
        parent::init();
        $theme = new Theme;
        $this->sourcePath = $theme->basePath . '/assets/app';
    }
}
