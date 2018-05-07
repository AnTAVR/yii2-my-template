<?php

namespace app\tests\acceptance;

use app\tests\AcceptanceTester;
use Yii;

class IndexCest
{
    public function checkOpenIndexPage(AcceptanceTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see(Yii::$app->params['brandLabel']);
    }
}
