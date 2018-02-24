<?php

namespace app\themes\basic\assets;

use app\themes\BasicTheme as Theme;
use app\assets\AppSiteAsset as OldAppSiteAsset;

class AppSiteAsset extends OldAppSiteAsset
{
    public function init()
    {
        parent::init();
        $theme = new Theme;
        $this->sourcePath = $theme->basePath . '/assets/app';
    }
}
