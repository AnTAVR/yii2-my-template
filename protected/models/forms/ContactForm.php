<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string',
                'max' => $params['string.max']],

            ['subject', 'trim'],
            ['subject', 'required'],
            ['subject', 'string',
                'max' => $params['string.max']],

            ['body', 'trim'],
            ['body', 'required'],
            ['body', 'string',
                'max' => $params['contact.body.max']],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string',
                'max' => $params['email.max']],
            ['email', 'email'],

            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => Yii::t('app', 'How can I call you?'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @return bool whether the model passes validation
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
