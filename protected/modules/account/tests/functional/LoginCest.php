<?php

namespace account\tests\functional;

use tests\FunctionalTester;
use Yii;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->user->loginUrl);
    }

    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeLink('Login');
        $I->click('Login');
        $I->see('Login', 'h1');
    }
}
