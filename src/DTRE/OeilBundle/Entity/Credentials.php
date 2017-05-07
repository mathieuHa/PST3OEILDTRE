<?php
/**
 * Created by PhpStorm.
 * User: kafim
 * Date: 07/05/2017
 * Time: 12:14
 */

namespace DTRE\OeilBundle\Entity;


class Credentials
{
    protected $login;
    protected $password;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}