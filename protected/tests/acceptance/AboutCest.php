<?php

use yii\helpers\Url;

class AboutCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/static/about'));
    }

    public function aboutPageWorks(\AcceptanceTester $I)
    {
        $I->see('about', 'h1');
    }
}
