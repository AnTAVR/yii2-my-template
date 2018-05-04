<?php

namespace account\tests;

use Yii;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->user->loginUrl);
    }

    public function checkLoginPage(FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }
}
