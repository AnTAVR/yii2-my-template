<?php

use yii\helpers\Url;

class LoginCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/account/login'));
    }

    public function homePageWorks(\AcceptanceTester $I)
    {
        $I->see('Login', 'h1');
    }

    public function ensureThatLoginWorks(\AcceptanceTester $I)
    {
        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'adminadmin');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Logout');
    }
}
