<?php

namespace frontend\tests\functional;

use Yii;

class HomeCest
{
    public function checkOpen(\FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('brandLabel');
        $I->seeLink('About');
        $I->click('About');
        $I->see('About', 'h1');
    }
}