## User Entity with annotations

Acme\DemoBundle\Entity\User

    <?php

    namespace Acme\DemoBundle\Entity;

    use EE\LightUserBundle\Entity\User as BaseUser;

    /**
     * Class User
     */
    class User extends BaseUser
    {
        /**
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

    }


Acme\DemoBundle\Resources\config\doctrine\User.orm.yml

    EE\WBSBundle\Entity\User:
        type: entity
        table: null
        fields:
            id:
                type: integer
                id: true
                generator:
                    strategy: AUTO
        lifecycleCallbacks: {  }
