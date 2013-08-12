<?php

namespace EE\LightUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EE\LightUserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @author Konrad Podgórski <konrad.podgorski@gmail.com>
 */
class User extends BaseUser
{
    /** @ORM\Column(name="username", type="string", length=255) */
    protected $username;

    /** @ORM\Column(name="username_canonical", type="string", length=255, unique=true) */
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