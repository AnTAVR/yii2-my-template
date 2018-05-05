<?php

namespace app\tests\acceptance;

use app\tests\AcceptanceTester;
use Yii;

class AcceptanceHomeCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function checkOpenHomePage(AcceptanceTester $I)
    {
        $I->see(Yii::$app->params['brandLabel']);
    }
}
