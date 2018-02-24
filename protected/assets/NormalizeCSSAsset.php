<?php

namespace app\assets;

use yii\web\AssetBundle;


class NormalizeCSSAsset extends AssetBundle
{
    public $sourcePath = '@bower/normalize-css';
    public $css = [
        'normalize.css',
    ];
}
