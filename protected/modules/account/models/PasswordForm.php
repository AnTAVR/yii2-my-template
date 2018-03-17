<?php

namespace app\modules\account\models;

use Yii;
use yii\helpers\ArrayHelper;

class PasswordForm extends User
{
    use PasswordTrait;

    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['verifyCode', 'captcha'],

            ['email', 'required'],
            ['email', 'string', 'max' => Yii::$app->params['email.max']],
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
}
