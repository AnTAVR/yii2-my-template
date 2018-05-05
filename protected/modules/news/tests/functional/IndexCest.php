<?php

namespace news\tests\functional;

use news\tests\FunctionalTester;

class IndexCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['/news']);
    }

    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->see('News', 'h1');
    }
}
