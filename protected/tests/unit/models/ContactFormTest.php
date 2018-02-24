<?php

namespace tests\models;

use Codeception\Test\Unit;

class ContactFormTest extends Unit
{
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @var \UnitTester
     */
    public $tester;
    /** @var \app\models\ContactForm */
    private $model;

    public function testEmailIsSentOnContact()
    {
        $this->model = $this->getMockBuilder('app\models\ContactForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($this->model->contact('admin@example.com'));

        // using Yii2 module actions to check email was sent
        /** @noinspection PhpUndefinedMethodInspection */
        $this->tester->seeEmailIsSent();
        /* @var /C */

        /** @noinspection PhpUndefinedMethodInspection */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        /** @noinspection PhpUndefinedMethodInspection */
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        /** @noinspection PhpUndefinedMethodInspection */
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
        /** @noinspection PhpUndefinedMethodInspection */
        expect($emailMessage->getSubject())->equals('very important letter subject');
        /** @noinspection PhpUndefinedMethodInspection */
        expect($emailMessage->toString())->contains('body of current message');
    }
}
