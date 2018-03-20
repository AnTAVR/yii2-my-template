<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class SignupForm extends User
{
    public $password;
    public $repeatPassword;
    public $verifyRules;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $params = Yii::$app->getModule('account')->params;
        $rules = [
            ['verifyCode', 'captcha'],

            ['verifyRules', 'boolean'],
            ['verifyRules', 'compare',
                'compareValue' => 1,
                'message' => Yii::t('app', 'You must agree with the rules')],

            ['username', 'required'],
            ['username', 'string',
                'max' => $params['username.max'],
                'min' => $params['username.min']],
            ['username', 'match',
                'pattern' => $params['username.pattern']],

            ['password', 'required'],
            ['password', 'string',
                'max' => $params['password.max'],
                'min' => $params['password.min']],

            ['repeatPassword', 'required'],
            ['repeatPassword', 'compare',
                'compareAttribute' => 'password'],

            ['email', 'required'],
            ['email', 'string',
                'max' => Yii::$app->params['email.max']],
            ['email', 'email'],

            ['username', 'unique'],
            ['email', 'unique'],
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat password'),
            'verifyRules' => Yii::t('app', 'Verify Rules'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $params = Yii::$app->getModule('account')->params;
        $hints = [
            'username' => Yii::t('app', 'Possible characters ({chars})', ['chars' => $params['username.hint']]),
            'email' => Yii::t('app', 'E-Mail must be valid, a letter with instructions will be sent to it.'),
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
            'verifyRules' => Html::a(Yii::t('app', 'Rules'), ['/static/index', 'meta_url' => 'rules'], ['class' => 'label label-success', 'target' => '_blank']),
        ];
        return ArrayHelper::merge(parent::attributeHints(), $hints);
    }

    public function signup($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        return true;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param UserToken $tokenModel
     * @param string $url
     * @return boolean whether the email was sent
     * @throws \yii\base\InvalidConfigException
     */
    public function sendEmail_VerifyEmail(UserToken $tokenModel)
    {
        $url = Url::to(['/account/signup/verify-email', 'token' => $tokenModel->code], true);
        $body = Yii::t('app', 'To confirm E-Mail, follow the link: {url}', ['url' => $url]);
        $body .= "\n";
        $body .= Yii::t('app', 'Is valid until: {expires}', ['expires' => $tokenModel->getExpiresTxt()]);
        $body .= "\n";
        $body .= "\n";
        $body .= Yii::t('app', 'IP: {ip}', ['ip' => Yii::$app->request->userIP]);
        $subject = Yii::t('app', 'Registration on the site {site}', ['site' => Yii::$app->name]);

        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{appname} robot', ['appname' => Yii::$app->name])])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();

    }
}
