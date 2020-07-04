<?php

namespace app\tests\functional;

use app\tests\FunctionalTester as Tester;
use Codeception\Scenario;
use Yii;

/* @var $scenario Scenario */
class IndexCest
{
    public function checkOpenIndexPage(Tester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeResponseCodeIs(200);
        $I->see(Yii::$app->params['brandLabel']);
    }

    public function checkOpenSiteIndexPage(Tester $I)
    {
        $I->amOnPage(['/site']);
        $I->seeResponseCodeIs(200);
        $I->see(Yii::$app->params['brandLabel']);
    }

    public function checkOpenAdminSiteIndexPageForbidden(Tester $I)
    {
        $I->amOnPage(['/admin-site']);
        $I->see('403');
        $I->seeResponseCodeIs(403);
    }

    public function checkOpenNotSetPage(Tester $I)
    {
        $I->amOnPage(['/tsdfgsd']);
        $I->seePageNotFound();
    }
}
