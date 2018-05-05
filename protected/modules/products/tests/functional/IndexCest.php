<?php

namespace products\tests\functional;

use products\tests\FunctionalTester;

class IndexCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['/products']);
    }

    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->see('Products', 'h1');
    }
}
