<?php

namespace account\tests\functional;

use account\tests\FunctionalTester;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
    }

    public function checkLoginPage(FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }
}
