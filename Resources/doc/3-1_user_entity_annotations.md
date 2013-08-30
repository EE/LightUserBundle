## User Entity with annotations

Acme\DemoBundle\Entity\User

    <?php

        namespace Acme\DemoBundle\Entity;

        use Doctrine\ORM\Mapping as ORM;
        use EE\LightUserBundle\Entity\User as BaseUser;

        /**
         * @ORM\Entity()
         * @ORM\Table(name="light_user")
         */
        class User extends BaseUser {

            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             * @var integer
             */
            protected $id;

            /**
             * @return integer
             */
            public function getId()
            {
                return $this->id;
            }

            /**
             * Returns the username used to authenticate the user.
             *
             * @return string The username
             */
            public function getUsername()
            {
                return $this->getId();
            }
        }
