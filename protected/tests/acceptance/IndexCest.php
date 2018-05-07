<?php

namespace app\tests\acceptance;

use app\tests\AcceptanceTester;
use Yii;

class IndexCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
    }

    public function checkOpenIndexPage(AcceptanceTester $I)
    {
        $I->see(Yii::$app->params['brandLabel']);
    }
}
