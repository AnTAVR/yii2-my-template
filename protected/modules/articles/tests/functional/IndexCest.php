<?php

namespace articles\tests\functional;

use articles\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
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
