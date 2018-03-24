<?php

namespace tests\functional;

use tests\FunctionalTester;

class StaticCest
{
    public $content_static = ['', 'rules'];

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
