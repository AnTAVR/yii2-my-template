<?php

namespace callback\tests\unit\models;

use app\modules\callback\models\forms\CallbackForm;
use Codeception\Test\Unit;
use contact\tests\UnitTester as Tester;
use Yii;

class CallbackFormTest extends Unit
{
    /**
     * @var Tester
     */
    public $tester;

    public function testSendEmail()
    {
        $emailName = 'Tester';
        $emailFhone = '+7(911) 11-111-11';

        $model = new CallbackForm();

        $model->attributes = [
            'name' => $emailName,
            'phone' => $emailFhone,
            'verifyCode' => 'testme',
        ];

        expect($model->validate())->true();
        expect_that($model->sendEmail());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey(Yii::$app->params['adminEmail']);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['supportEmail']);
        $i18n = Yii::$app->i18n;
        expect($emailMessage->getSubject())->equals($i18n->format('Request for a call back from {site}', ['site' => Yii::$app->name], 'us'));
        expect($emailMessage->toString())->contains($i18n->format('Phone {phone}, name {name}', ['phone' => $emailFhone, 'name' => $emailName], 'us'));
    }
}
