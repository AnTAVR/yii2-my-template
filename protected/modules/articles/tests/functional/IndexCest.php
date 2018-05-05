<?php

namespace articles\tests\functional;

use articles\tests\FunctionalTester;

class IndexCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['/articles']);
    }

    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->see('Articles', 'h1');
    }
}
