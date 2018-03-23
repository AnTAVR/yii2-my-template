<?php

namespace app\widgets\CKEditor;

use yii\web\AssetBundle;

class CKEditorHighlightAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ckeditor/ckeditor/';
    public $js = [
        'plugins/codesnippet/lib/highlight/highlight.pack.js',
    ];
    public $css = [
        'plugins/codesnippet/lib/highlight/styles/default.css',
    ];

    public $jsCode = [
        'jQuery("pre code").each(function(i, block) {hljs.highlightBlock(block);});',
    ];

    /**
     * @param \yii\web\View $view :
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        foreach ($this->jsCode as $code__) {
            if (is_array($code__)) {
                $code = array_shift($code__);
                $position = array_shift($code__);
                $view->registerJs($code, $position);
            } else {
                if ($code__ !== null) {
                    $view->registerJs($code__, $view::POS_READY);
                }
            }
        }
    }
}
