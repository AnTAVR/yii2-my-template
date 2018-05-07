<?php

namespace news\tests\functional;

use news\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class IndexCest
{
    public function _before(Tester $I)
    {
        $I->amOnPage(['/news']);
    }

    public function checkOpenIndexPage(Tester $I)
    {
        $I->see('News', 'h1');
    }
}
