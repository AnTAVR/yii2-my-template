<?php

namespace tests\functional;

use tests\FunctionalTester;
use Yii;

class HomeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
    }

    public function checkOpen(FunctionalTester $I)
    {
        $I->see('brandLabel');
    }
}
