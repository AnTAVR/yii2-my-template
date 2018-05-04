<?php

namespace app\tests;

class StaticCest
{
    public function checkAboutPage(FunctionalTester $I)
    {
        $I->amOnPage(['/static/index', 'meta_url' => 'about']);
        $I->see('about');
    }

    public function checkRulesPage(FunctionalTester $I)
    {
        $I->amOnPage(['/static/index', 'meta_url' => 'rules']);
        $I->see('rules');
    }
}
