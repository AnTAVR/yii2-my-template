<?php

namespace app\modules\account\models;

/**
 * @property string $tokenRaw
 * @property string $token
 * @property string $salt
 * @property string $password_hash
 */
trait PasswordTrait
{
    public function getTokenRaw()
    {
        return $this->salt . $this->password_hash;
    }

    public function getToken()
    {
        return hash('sha256', $this->tokenRaw);
    }
}