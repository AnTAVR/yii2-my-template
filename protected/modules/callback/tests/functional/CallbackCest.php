<?php

namespace callback\tests\functional;

use callback\tests\FunctionalTester;

/* @var $scenario \Codeception\Scenario */
class CallbackCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['/callback']);
    }

    public function checkCallbackPage(FunctionalTester $I)
    {
        $I->see('Request for a call back', 'h1');
    }

    public function checkCallbackSubmitNoData(FunctionalTester $I)
    {
        $I->submitForm('#callback-form', []);
        $I->see('Request for a call back', 'h1');
        $I->seeValidationError('Contact number cannot be blank');
        $I->seeValidationError('Name cannot be blank.');
//        $I->seeValidationError('The verification code is incorrect');
    }

    public function checkCallbackSubmitNotCorrectPhone(FunctionalTester $I)
    {
        $I->submitForm('#callback-form', [
            'CallbackForm[name]' => 'tester',
            'CallbackForm[phone]' => 'tester.email',
            'CallbackForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('The format of Contact number is invalid.');
        $I->dontSeeValidationError('How can I call you? cannot be blank.');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkCallbackSubmitCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#callback-form', [
            'CallbackForm[name]' => 'tester',
            'CallbackForm[phone]' => '+7(911) 11-111-11',
            'CallbackForm[verifyCode]' => 'testme',
        ]);
        $I->dontSeeValidationError('The format of Contact number is invalid.');
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us.');
    }
}
