<?php

namespace app\modules\account\models;

/**
 * @property string $tokenPasswordRaw
 * @property string $tokenPassword
 * @property string $salt
 * @property string $password_hash
 */
trait PasswordTrait
{
    public function getTokenPasswordRaw()
    {
        return $this->salt . $this->password_hash;
    }

    public function getTokenPassword()
    {
        return hash('sha256', $this->tokenPasswordRaw);
    }
}