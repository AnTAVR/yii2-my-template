<?php

namespace app\widgets\Thumbnail;

use yii\web\AssetBundle;

class ThumbnailAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/Thumbnail/assets';

    public $js = [
        'thumbnail.js',
    ];

    public $css = [
        'thumbnail.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}