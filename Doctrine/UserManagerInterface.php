<?php

namespace EE\LightUserBundle\Doctrine;

use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface $user
     * @param bool $flush
     *
     * @return mixed
     */
    public function updateUser(UserInterface $user, $flush = true);

    public function findUserByUsername($username);

    /**
     * @return string
     */
    public function getClass();

}