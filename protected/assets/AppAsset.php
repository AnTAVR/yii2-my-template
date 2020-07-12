<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
//    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'app\assets\NormalizeCSSAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapThemeAsset',
        'app\widgets\CKEditor\CKEditorHighlightAsset',
    ];
}
