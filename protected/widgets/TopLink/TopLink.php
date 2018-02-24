<?php
namespace app\widgets\TopLink;

use Yii;
use yii\base\Widget;

class TopLink extends Widget
{
    public $idw = 'toplink';
    public $icon = 'arrow-up';
    public $text;
    public $echoText = false;

    public function init()
    {
        parent::init();

        if (empty($this->text))
            $this->text = Yii::t('app', 'Up');
        $this->registerClientScript();
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        TopLinkAsset::register($this->view);
    }

    public function run()
    {
        $text = '';
        if ($this->echoText) {
            $text = $this->text;
        }
        return <<<HTML
<div id="$this->idw" class="toplink" title="$this->text">
<span class="glyphicon glyphicon-$this->icon"></span>
$text
</div>
HTML;
    }

}
