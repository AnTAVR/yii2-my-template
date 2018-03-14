<?php

namespace app\modules\account\models;

class PasswordEditForm extends User
{
    /**
     * @return bool
     */
    public function edit()
    {
        return true;
    }
}
