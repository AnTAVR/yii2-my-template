<?php

namespace app\modules\account\models\forms;

use app\modules\account\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class RecoveryPasswordRequestForm extends User
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
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
