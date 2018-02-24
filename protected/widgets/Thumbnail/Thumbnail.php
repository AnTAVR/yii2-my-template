<?php

namespace app\widgets\Thumbnail;

use Yii;
use yii\base\Widget;

class Thumbnail extends Widget
{
    public $textClose;
    public $textView;

    public function init()
    {
        parent::init();

        if (empty($this->textClose))
            $this->textClose = Yii::t('app', 'Close');
        if (empty($this->textView))
            $this->textView = Yii::t('app', 'View image');

        $this->registerClientScript();
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        ThumbnailAsset::register($this->view);
    }

    public function run()
    {
        return <<<HTML
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="$this->textClose"><span aria-hidden="true">×</span></button>
        <div class="modal-title">$this->textView</div>
      </div>
      <div class="modal-body">
        <img class="img-responsive center-block" src="" alt="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">$this->textClose</button>
      </div>
    </div>
  </div>
</div>
HTML;
    }

}