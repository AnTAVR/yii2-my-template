<?php

namespace account;

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

    public function checkOpenLoginPage(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeLink('Login');
        $I->click('Login');
        $I->see('Login', 'h1');
    }
}
