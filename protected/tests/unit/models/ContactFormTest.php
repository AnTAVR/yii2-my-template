<?php

namespace tests\unit\models;

use app\models\ContactForm;
use Codeception\Test\Unit;

class ContactFormTest extends Unit
{
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
            'verifyCode' => 'testme',
        ];

        expect($model->validate())->true();
        expect_that($model->sendEmail('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->contains('body of current message');
    }
}
