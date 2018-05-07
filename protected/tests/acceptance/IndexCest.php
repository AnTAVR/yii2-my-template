<?php

namespace app\tests\acceptance;

use app\tests\AcceptanceTester as Tester;
use Yii;

class IndexCest
{
    public function checkOpenIndexPage(Tester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see(Yii::$app->params['brandLabel']);
    }
}
