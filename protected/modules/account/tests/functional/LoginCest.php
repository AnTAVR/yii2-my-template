<?php

namespace account\tests\functional;

use account\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class LoginCest
{
    public function _before(Tester $I)
    {
        $I->amOnPage(['/site/login']);
    }

    public function checkLoginPage(Tester $I)
    {
        $I->see('Login', 'h1');
    }
}
