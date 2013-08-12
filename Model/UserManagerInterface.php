<?php

namespace EE\LightUserBundle\Model;

use EE\LightUserBundle\Model\User;

/**
 * Class UserManagerInterface
 *
 * @author Konrad Podgórski <konrad.podgorski@gmail.com>
 */
interface UserManagerInterface {

    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createUser();

    /**
     * @param User $user
     * @param bool $flush
     *
     * @return mixed
     */
    public function updateUser(User $user, $flush = false);

    public function findUserByUsername($username);

    /**
     * @return string
     */
    public function getClass();

}