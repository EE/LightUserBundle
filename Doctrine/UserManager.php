<?php

namespace EE\LightUserBundle\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use EE\LightUserBundle\Doctrine\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    public function updateUser(UserInterface $user, $flush = true)
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

    /**
     * Returns a user by its username
     *
     * @param string $username
     *
     * @return UserInterface
     */
    public function findUserByUsername($username)
    {
        $usernameCanonical = $this->canonicalize($username);

        return $this->repository->findOneBy(array('usernameCanonical'=> $usernameCanonical));
    }

    /**
     * Returns a user by its ID
     *
     * @param integer $id
     *
     * @return UserInterface
     */
    public function findUserById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Returns a user that match given criteria
     * Internally uses findOneBy on entity repository
     *
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
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