<?php

namespace rbac\tests\functional;

use Codeception\Scenario;
use rbac\tests\FunctionalTester as Tester;

/* @var $scenario Scenario */
class IndexCest
{
    public function checkOpenIndexPage(Tester $I)
    {
        $I->amOnPage(['/rbac']);
        $I->seeResponseCodeIs(404);
    }
}
