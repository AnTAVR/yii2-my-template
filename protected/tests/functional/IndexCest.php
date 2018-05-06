<?php

namespace app\tests\functional;

use app\tests\FunctionalTester;
use Yii;

class IndexCest
{
    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see(Yii::$app->params['brandLabel']);
    }

    public function checkOpenNotSetPage(FunctionalTester $I)
    {
        $I->amOnPage(['/tsdfgsd']);
        $I->seeResponseCodeIs(404);
    }
}
