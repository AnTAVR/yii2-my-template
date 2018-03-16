<?php

namespace app\modules\account\models;

/**
 * @property string salt
 * @property string password_hash
 * @property string passwordToken
 */
trait PasswordTrait
{
    /**
     * @return string
     */
    public function passwordTokenRaw()
    {
        return $this->salt . $this->password_hash;
    }

    /**
     * @return string
     */
    public function getPasswordToken()
    {
        return hash('sha256', $this->passwordTokenRaw());
    }

    /**
     * @param string $token
     * @return boolean
     */
    public function validatePasswordToken($token)
    {
        return $token === $this->passwordToken;
    }
}