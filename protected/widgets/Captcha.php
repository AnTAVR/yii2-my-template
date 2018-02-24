<?php

namespace app\widgets;

use Yii;
use yii\captcha\Captcha as CaptchaOld;

class Captcha extends CaptchaOld
{
    public $options = ['value' => '', 'class' => 'form-control'];
    public $template = '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>';
    public $imageOptions = ['style' => 'cursor: pointer;'];
    public $captchaAction = '/site/captcha';

    public function init()
    {
        if (!isset($this->imageOptions['title'])) {
            $this->imageOptions['title'] = Yii::t('app', 'Get new code');
        }

        parent::init();
    }
}
