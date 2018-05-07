<?php

namespace account\tests\functional;

use account\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class IndexCest
{
    public function checkOpenIndexPageForbidden(Tester $I)
    {
        $I->amOnPage('/account');
        $I->see('403');
        $I->seeResponseCodeIs(403);
    }
}
