<?php

namespace app\widgets\CKEditor;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ckeditor/ckeditor/';
    public $js = [
        'ckeditor.js',
        'adapters/jquery.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
