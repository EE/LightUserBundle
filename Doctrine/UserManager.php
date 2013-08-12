<?php

namespace EE\LightUserBundle\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use EE\LightUserBundle\Model\UserManagerInterface;
use EE\LightUserBundle\Model\User;

/**
 * Class UserManager
 *
 * @author Konrad Podgórski <konrad.podgorski@gmail.com>
 */
class UserManager implements UserManagerInterface
{

    protected $class;
    protected $repository;

    public function __construct(Registry $doctrine, $class)
    {
        $this->manager = $doctrine->getManager();

        $metadata = $this->manager->getClassMetadata($class);
        $this->class = $metadata->getName();

        $this->repository = $this->manager->getRepository($this->getClass());

    }

    public function updateUser(User $user, $flush = true)
    {
        $usernameCanonical = $this->canonicalize($user->getUsername());

        $user->setUsernameCanonical($usernameCanonical);

        $this->manager->persist($user);

        if ($flush) {
            $this->manager->flush();
        }
    }

    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createUser()
    {
        $class = $this->getClass();
        $user = new $class;

        return $user;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    public function findUserByUsername($username)
    {
        $usernameCanonical = $this->canonicalize($username);

        return $this->repository->findOneBy(array('usernameCanonical'=> $usernameCanonical));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function canonicalize($string)
    {
        return mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

}