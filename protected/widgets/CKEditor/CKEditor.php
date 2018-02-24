<?php

namespace app\widgets\CKEditor;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class CKEditor extends InputWidget
{
    const STANDARD = 'standard';
    const CUSTOM = 'custom';

    public $preset = self::STANDARD;
    public $presetPath = 'presets/';
    public $clientOptions = [];

    public function init()
    {
        parent::init();

        $preset = null;

        if ($this->preset !== self::CUSTOM) {
            $fileName = $this->presetPath . $this->preset . '.php';
            if (is_file(__DIR__ . DIRECTORY_SEPARATOR . $fileName)) {
                $preset = $fileName;
            }
        }

        if ($preset !== null) {
            /** @noinspection PhpIncludeInspection */
            $options = require $preset;
            $this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
        }


        $js = [
//            'CKEDITOR.config.indentClasses = ["thumbnail"];',
            'CKEDITOR.config.protectedSource.push(/<(style)[^>]*>.*<\/style>/ig);', // разрешить теги <style>
            'CKEDITOR.config.protectedSource.push(/<(script)[^>]*>.*<\/script>/ig);', // разрешить теги <script>
            'CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g);', // разрешить php-код
            'CKEDITOR.config.protectedSource.push(/<!--dev-->[\s\S]*<!--\/dev-->/g);', // разрешить любой код: <!--dev-->код писать вот тут<!--/dev-->
//            'CKEDITOR.config.allowedContent = true;', // all tags
        ];

        $this->view->registerJs(implode("\n", $js));
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        CKEditorWidgetAsset::register($this->view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        $js = [
            "CKEDITOR.replace('$id', $options);",
        ];

        $this->view->registerJs(implode("\n", $js));
    }
}
