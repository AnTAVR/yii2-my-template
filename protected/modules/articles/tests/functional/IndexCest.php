<?php

namespace articles\tests\functional;

use articles\tests\FunctionalTester as Tester;
use Codeception\Scenario;

/* @var $scenario Scenario */
class IndexCest
{
    public function _before(Tester $I)
    {
        $I->amOnPage(['/articles']);
    }

    public function checkOpenIndexPage(Tester $I)
    {
        $I->see('Articles', 'h1');
    }
}
