<?php

namespace app\widgets\UrlTranslit;

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class UrlTranslit extends InputWidget
{
    public $dictTranslate = [
        ['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
        ['д', 'd'], ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'],
        ['з', 'z'], ['и', 'i'], ['й', 'y'], ['к', 'k'],
        ['л', 'l'], ['м', 'm'], ['н', 'n'], ['о', 'o'],
        ['п', 'p'], ['р', 'r'], ['с', 's'], ['т', 't'],
        ['у', 'u'], ['ф', 'f'], ['х', 'h'], ['ц', 'c'],
        ['ч', 'ch'], ['ш', 'sh'], ['щ', 'sch'], ['ъ', ''],
        ['ы', 'y'], ['ь', ''], ['э', 'e'], ['ю', 'yu'],
        ['я', 'ya'], ['і', 'i'], ['є', 'je'], ['ї', 'ji'],
        ['ґ', 'g']
    ];
    public $fromField;
    public $template = '{icon}{input}';
    public $icon = 'link';
    public $clientOptions = [];

    public function init()
    {
        parent::init();
        $dictTranslate = Json::encode($this->dictTranslate);
        $this->view->registerJs("$().UrlTranslit.defaults.dictTranslate = $dictTranslate;");
    }

    public function run()
    {
        echo Html::beginTag('div', ['class' => 'input-group']);

        if (!isset($this->options['class']))
            $this->options['class'] = 'form-control';

        $iconId = 'icon-' . $this->options['id'];

        if (!isset($this->options['aria-describedby']))
            $this->options['aria-describedby'] = $iconId;

        if ($this->hasModel()) {
            $replace['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $replace['{input}'] = Html::textInput($this->name, $this->value, $this->options);

        }
        if ($this->icon != '')
            $replace['{icon}'] = Html::tag('span',
                Icon::show($this->icon, [], Icon::FA),
                ['class' => 'input-group-addon', 'id' => $iconId]);

        echo strtr($this->template, $replace);

        echo Html::endTag('div');

        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        UrlTranslitAsset::register($this->view);

        if ($this->icon != '') {
            Icon::map($this->view);
        }

        $id = $this->hasModel() ? Html::getInputId($this->model, $this->fromField) : $this->fromField;
        $selector = "jQuery('#$id')";
        $this->clientOptions['destination'] = $this->options['id'];

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';

        $this->view->registerJs("$selector.UrlTranslit($options);");
    }
}