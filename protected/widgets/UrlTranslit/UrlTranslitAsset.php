<?php

namespace app\widgets\UrlTranslit;

use yii\web\AssetBundle;

class UrlTranslitAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/UrlTranslitAsset/assets';

    public $js = [
        'js/jquery.url-translit.js',
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
