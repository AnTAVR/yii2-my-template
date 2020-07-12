<?php

namespace app\themes\basic\assets;

use app\themes\BasicTheme as Theme;
use yii\web\AssetBundle;

class BasicAsset extends AssetBundle
{
    public $css = [
        'css/basic.css',
    ];
    public $js = [
        'js/basic.js',
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
