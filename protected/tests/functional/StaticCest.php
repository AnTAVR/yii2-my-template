<?php

namespace app\tests\functional;

use app\tests\FunctionalTester;

class StaticCest
{
    public function checkOpenAboutPage(FunctionalTester $I)
    {
        $I->amOnPage(['/static/index', 'meta_url' => 'about']);
        $I->see('about');
    }

    public function checkOpenRulesPage(FunctionalTester $I)
    {
        $I->amOnPage(['/static/index', 'meta_url' => 'rules']);
        $I->see('rules');
    }
}
