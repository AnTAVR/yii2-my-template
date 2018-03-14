<?php

namespace app\modules\account\models;

class PasswordResetForm extends User
{
    /**
     * @return bool
     */
    public function reset()
    {
        return true;
    }
}
