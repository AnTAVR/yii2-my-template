<?php

namespace app\themes\basic\assets;

use app\themes\BasicTheme;
use app\assets\AppSiteAsset as OldAppSiteAsset;

class AppSiteAsset extends OldAppSiteAsset
{
    public function init()
    {
        parent::init();
        $theme = new BasicTheme;
        $this->sourcePath = $theme->basePath . '/assets/app';
    }
}
