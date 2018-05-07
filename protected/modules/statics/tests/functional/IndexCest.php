<?php

namespace statics\tests\functional;

use statics\tests\FunctionalTester as Tester;

/* @var $scenario \Codeception\Scenario */
class IndexCest
{
    public function checkOpenIndexPage(Tester $I)
    {
        $I->amOnPage(['/statics']);
        $I->seeResponseCodeIs(404);
    }

    public function checkOpenAboutPage(Tester $I)
    {
        $I->amOnPage(['/statics/default/index', 'meta_url' => 'about']);
        $I->see('about');
    }

    public function checkOpenRulesPage(Tester $I)
    {
        $I->amOnPage(['/statics/default/index', 'meta_url' => 'rules']);
        $I->see('rules');
    }
}
