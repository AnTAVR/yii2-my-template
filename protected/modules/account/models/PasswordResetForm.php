<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

class PasswordResetForm extends User
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->params;
        $rules = [
            ['verifyCode', 'captcha'],

            ['email', 'required'],
            ['email', 'string', 'max' => $params['email.max']],
            ['email', 'email'],

            ['email', 'exist'],
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $hints = [
            'email' => Yii::t('app', 'Enter E-Mail corresponding to the account, it will be sent an email with instructions.'),
        ];
        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    /**
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {
        $body = Yii::t('app', 'Phone {phone}, name {name}', ['phone' => $this->phone, 'name' => $this->name]);
        $subject = Yii::t('app', 'Password recovery from {site}', ['site' => Yii::$app->name]);

        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{appname} robot', ['appname' => Yii::$app->name])])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }
}
