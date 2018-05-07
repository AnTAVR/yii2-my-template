<?php

namespace rbac\tests\functional;

use rbac\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class IndexCest
{
    public function checkOpenIndexPage(Tester $I)
    {
        $I->amOnPage(['/rbac']);
        $I->seeResponseCodeIs(404);
    }
}
