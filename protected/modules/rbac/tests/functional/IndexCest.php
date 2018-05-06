<?php

namespace rbac\tests\functional;

use rbac\tests\FunctionalTester;

class IndexCest
{
    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->amOnPage(['/rbac']);
        $I->seeResponseCodeIs(404);
    }
}
