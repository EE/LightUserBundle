<?php

namespace EE\LightUserBundle\Entity;

use EE\LightUserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @author Konrad Podgórski <konrad.podgorski@gmail.com>
 */
abstract class User extends BaseUser
{
    protected $username;

    protected $usernameCanonical;

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $usernameCanonical
     *
     * @return $this
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }


}