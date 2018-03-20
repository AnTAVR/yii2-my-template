<?php

use yii\helpers\Url;

class HomeCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
    }

    public function homePageWorks(\AcceptanceTester $I)
    {
        $I->see('My Company');
    }

    public function ensureThatHomePageWorks(\AcceptanceTester $I)
    {
        $I->seeLink('About');
        $I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');
    }
}
