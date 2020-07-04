<?php

namespace products\tests\functional;

use Codeception\Scenario;
use products\tests\FunctionalTester as Tester;

/* @var $scenario Scenario */
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
