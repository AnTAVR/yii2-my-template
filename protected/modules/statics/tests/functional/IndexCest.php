<?php

namespace statics\tests\functional;

use statics\tests\FunctionalTester;

class IndexCest
{
    public function checkOpenIndexPage(FunctionalTester $I)
    {
        $I->amOnPage(['/statics']);
        $I->seeResponseCodeIs(404);
    }

    public function checkOpenAboutPage(FunctionalTester $I)
    {
        $I->amOnPage(['/statics/default/index', 'meta_url' => 'about']);
        $I->see('about');
    }

    public function checkOpenRulesPage(FunctionalTester $I)
    {
        $I->amOnPage(['/statics/default/index', 'meta_url' => 'rules']);
        $I->see('rules');
    }
}
