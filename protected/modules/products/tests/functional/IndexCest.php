<?php

namespace products\tests\functional;

use products\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class IndexCest
{
    public function _before(Tester $I)
    {
        $I->amOnPage(['/products']);
    }

    public function checkOpenIndexPage(Tester $I)
    {
        $I->see('Products', 'h1');
    }
}
