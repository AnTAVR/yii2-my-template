<?php

namespace app\tests\functional;

use app\tests\FunctionalTester;
use Yii;

class HomeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
    }

    public function checkOpenHomePage(FunctionalTester $I)
    {
        $I->see(Yii::$app->params['brandLabel']);
    }
}
