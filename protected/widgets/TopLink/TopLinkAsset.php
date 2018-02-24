<?php
namespace app\widgets\TopLink;

use yii\web\AssetBundle;

class TopLinkAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/TopLink/assets';

    public $css = [
        'toplink.css',
    ];

    public $js = [
        'toplink.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}