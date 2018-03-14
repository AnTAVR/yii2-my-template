<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * CallbackForm
 */
class CallbackForm extends Model
{
    public $phone;
    public $name;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $params = Yii::$app->params;
        return [
            ['phone', 'required'],
            ['phone', 'string',
                'max' => 20,
                'min' => 11],

            ['name', 'required'],
            ['name', 'string',
                'max' => $params['contact.name.max']],

            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('app', 'Contact number'),
            'name' => Yii::t('app', 'How can I call you?'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    public function attributeHints()
    {
        return [
            'phone' => Yii::t('app', 'For example: {example}', ['example' => '+7 (111) 111-1111']),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {
        $body = Yii::t('app', 'Phone {phone}, name {name}', ['phone' => $this->phone, 'name' => $this->name]);
        $subject = Yii::t('app', 'Application for a callback from {site}', ['site' => Yii::$app->name]);

        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{appname} robot', ['appname' => Yii::$app->name])])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }
}
