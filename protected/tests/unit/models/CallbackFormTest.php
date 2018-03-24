<?php

namespace tests\unit\models;

use app\models\CallbackForm;
use Codeception\Test\Unit;
use Yii;

class CallbackFormTest extends Unit
{
    /**
     * @var \tests\UnitTester
     */
    public $tester;

    public function testSendEmail()
    {
        $model = new CallbackForm();

        $model->attributes = [
            'name' => 'Tester',
            'phone' => '+7(911) 11-111-11',
        ];

        expect_that($model->sendEmail());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey(Yii::$app->params['adminEmail']);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['supportEmail']);
        $i18n = Yii::$app->i18n;
        expect($emailMessage->getSubject())->equals($i18n->format('Request for a call back from {site}', ['site' => Yii::$app->name], 'us'));
        expect($emailMessage->toString())->contains($i18n->format('Phone {phone}, name {name}', ['phone' => $model->phone, 'name' => $model->name], 'us'));
    }
}
