<?php

namespace contact\tests\unit\models;

use app\modules\contact\models\forms\ContactForm;
use Codeception\Test\Unit;
use Yii;

class ContactFormTest extends Unit
{
    /**
     * @var \contact\tests\UnitTester
     */
    public $tester;

    public function testSendEmail()
    {
        $emailName = 'Tester';
        $emailFrom = 'tester@example.com';
        $emailSubject = 'very important letter subject';
        $emailBody = 'body of current message';

        $model = new ContactForm();

        $model->attributes = [
            'name' => $emailName,
            'email' => $emailFrom,
            'subject' => $emailSubject,
            'body' => $emailBody,
            'verifyCode' => 'testme',
        ];

        expect($model->validate())->true();
        expect_that($model->sendEmail());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey(Yii::$app->params['adminEmail']);
        expect($emailMessage->getFrom())->hasKey($emailFrom);
        expect($emailMessage->getSubject())->equals($emailSubject);
        expect($emailMessage->toString())->contains($emailBody);
    }
}
