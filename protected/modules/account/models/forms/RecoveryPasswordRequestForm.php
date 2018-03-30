<?php

namespace app\modules\account\models\forms;

use app\modules\account\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class RecoveryPasswordRequestForm extends User
{
    public $verifyCode;

    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => Yii::$app->params['email.max']],
            ['email', 'email'],

            ['email', 'exist'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'email' => Yii::t('app', 'Enter E-Mail corresponding to the account, it will be sent an email with instructions.'),
        ]);
    }
}
