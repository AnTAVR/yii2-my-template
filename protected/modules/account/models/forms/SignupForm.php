<?php

namespace app\modules\account\models\forms;

use app\modules\account\models\User;
use app\modules\account\models\UserToken;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class SignupForm extends User
{
    public $password;
    public $repeatPassword;
    public $verifyRules;
    public $verifyCode;

    public function rules()
    {
        $params = Yii::$app->getModule('account')->params;
        return [
            ['verifyCode', 'captcha'],

            ['verifyRules', 'boolean'],
            ['verifyRules', 'compare',
                'compareValue' => 1,
                'message' => Yii::t('app', 'You must agree with the rules')],

            ['username', 'trim'],
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

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string',
                'max' => Yii::$app->params['email.max']],
            ['email', 'email'],

            ['username', 'unique'],
            ['email', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat password'),
            'verifyRules' => Yii::t('app', 'Verify Rules'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ]);
    }

    public function attributeHints()
    {
        $params = Yii::$app->getModule('account')->params;
        return ArrayHelper::merge(parent::attributeHints(), [
            'username' => Yii::t('app', 'Possible characters ({chars})', ['chars' => $params['username.hint']]),
            'email' => Yii::t('app', 'E-Mail must be valid, a letter with instructions will be sent to it.'),
            'password' => Yii::t('app', 'Set a complex password using uppercase and lowercase letters, numbers and special characters.'),
            'verifyRules' => Html::a(Yii::t('app', 'Rules'), ['/statics/default/index', 'meta_url' => 'rules'], ['class' => 'label label-success', 'target' => '_blank']),
        ]);
    }

    public function signup($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);

        if (!$this->save(false)) {
            return false;
        }
        //the following three lines were added:
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('users-role');
        $auth->assign($role, $this->id);

        return true;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param UserToken $tokenModel
     * @return boolean whether the email was sent
     * @throws InvalidConfigException
     */
    public function sendEmail_VerifyEmail($tokenModel)
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

    public function sendVerifyEmailToken()
    {
        $tokenModel = UserToken::createConfirmEmailToken($this->id, $this->tokenEmail);
        if (!$tokenModel) {
            $this->addError('email', Yii::t('app', 'A letter with instructions has already been sent to E-Mail.'));
            return null;
        }
        return $this->sendEmail_VerifyEmail($tokenModel);
    }
}
