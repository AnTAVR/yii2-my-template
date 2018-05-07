<?php

namespace app\widgets\LinkPager;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager as oldLinkPager;

class LinkPager extends oldLinkPager
{
    public $jumpPageLabel = false;
    public $jumpPageCssClass = 'jump';
    public $jumpPageReplace = '{page_num}';

    /**
     * Initializes the pager.
     */
    public function init()
    {
        parent::init();

        $this->registerClientScript();
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        LinkPagerAsset::register($this->view);

        $tmpPage = 99989929799;
        $url = $this->pagination->createUrl($tmpPage - 1, null, true);
        $url = strrev(implode(strrev($this->jumpPageReplace), explode(strrev($tmpPage), strrev($url), 2)));

        $this->view->registerJs('$().LinkPager.url = "' . $url . '";');
        $this->view->registerJs('$().LinkPager.jumpPageReplace = "' . $this->jumpPageReplace . '";');

    }

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $jumpPageLabel = $this->jumpPageLabel === true ? Yii::t('app', 'Jump to:') : $this->jumpPageLabel;
        if ($jumpPageLabel !== false) {
            if ($pageCount > $this->maxButtonCount * 2) {
                $buttons[] = $this->renderJumpPage($jumpPageLabel, $currentPage + 1, $this->jumpPageCssClass);
            }
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        return Html::tag($tag, implode("\n", $buttons), $options);
    }

    /**
     * @param string $label the text label
     * @param int $page the page number
     * @param string $class the CSS class for the page button.
     * @return string the rendering result
     */
    protected function renderJumpPage($label, $page, $class)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        $input = Html::textInput(null, $page, ['class' => 'form-control',
            'onkeydown' => '$().LinkPager.onkeydown(this, event);']);

        $button = Html::button($label, ['class' => 'btn btn-default',
            'onclick' => '$().LinkPager.onclick(this);']);
        $button = Html::tag('span', $button, ['class' => 'input-group-btn']);

//        $button = Html::tag('span', $label, ['class' => 'input-group-addon']);

        $item = Html::tag('span', $button . $input, ['class' => 'input-group input-group-sm']);
        $item = Html::tag('span', $item, ['class' => 'col-lg-2', 'style' => 'padding: 1px;']);
        return Html::tag($linkWrapTag, $item, $options);
    }
}
