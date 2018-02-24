<?php

namespace app\widgets\CKEditor;

use yii\web\AssetBundle;

class CKEditorWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CKEditor/assets/';
    public $js = [
    ];
    public $depends = [
        'app\widgets\CKEditor\CKEditorAsset',
    ];
}
