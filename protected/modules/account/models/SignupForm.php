<?php

namespace app\modules\account\models;

use yii\base\Model;

class SignupForm extends Model
{
    use UserTrait;

    public function save()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

//  the following three lines were added:
//            $auth = Yii::$app->authManager;
//            $authorRole = $auth->getRole('author');
//            $auth->assign($authorRole, $user->getId());

            return $user;
        }

        return null;
    }
}
