<?php

namespace contact\tests\functional;

use Codeception\Scenario;
use contact\tests\FunctionalTester as Tester;

/* @var $scenario Scenario */
class IndexCest
{
    public function _before(Tester $I)
    {
        $I->amOnPage(['/contact']);
    }

    public function checkOpenIndexPage(Tester $I)
    {
        $I->see('Contact', 'h1');
    }

    public function checkContactSubmitNoData(Tester $I)
    {
        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Name cannot be blank');
        $I->seeValidationError('Email cannot be blank');
        $I->seeValidationError('Subject cannot be blank');
        $I->seeValidationError('Body cannot be blank');
//        $I->seeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNotCorrectEmail(Tester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitCorrectData(Tester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us.');
    }
}
